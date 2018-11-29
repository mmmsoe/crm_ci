<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Update extends CI_Controller {

    function Update() {
        parent::__construct();
        $this->load->database();
        //$this->load->model("update");
        $this->load->model("user_model");
        $this->load->library('form_validation');

        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        //check_login();
        if (is_login() == 0) {
            redirect(base_url('admin/login'), 'refresh');
        }
    }

    function index() {
        //checking permission for staff
        if (!check_staff_permission('pricelists_read')) {
            redirect(base_url('admin/access_denied'), 'refresh');
        }
        $data = '';
        $db_ver = $this->user_model->get_app_ver();
        if (APP_VER != $db_ver->ver) {
            $this->load->view('update/index2', $data);
        } else {
            $this->load->view('header');
            $this->load->view('update/index', $data);
            $this->load->view('footer');
        }
    }

    public function do_upload() {
        if ($_POST["label"]) {
            $label = $_POST["label"];
        }

        $path = "uploads/update_files/";

        $allowedExts = array("zip", "ZIP");

        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);

        if ((strpos($_FILES["file"]["name"], 'zip')) || (strpos($_FILES["file"]["name"], 'ZIP'))) {

            if ($_FILES["file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
            } else {
                $filename = $_FILES["file"]["name"];
                if (file_exists($path . $filename)) {
                    //unlink($path.$filename);
                    echo $filename . " already exists. ";
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"], $path . $filename);
                    //$this->backup_php();
                    $zip = new ZipArchive;
                    if ($zip->open($path . $filename) === TRUE) {
                        $zip->extractTo($path);
                        $zip->close();

                        $file_location = substr($path . $filename, 0, strlen($path . $filename) - 4);

                        //$this->update_mysql($file_location);
                        $this->update_php($file_location);//works only on linux systems
                    } else {
                        echo 'failed';
                    }
                }
            }
        } else {
            echo "Invalid file, only allow zip file";
        }
    }

    public function do_upload2() {
        if ($_POST["label"]) {
            $label = $_POST["label"];
        }

        $path = "uploads/update_files/";

        $allowedExts = array("zip", "ZIP");

        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);

        if ((strpos($_FILES["file"]["name"], 'zip')) || (strpos($_FILES["file"]["name"], 'ZIP'))) {

            if ($_FILES["file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
            } else {
                $filename = $_FILES["file"]["name"];

                if (file_exists($path . $filename)) {
                    echo $filename . " already exists. ";
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"], $path . $filename);

                    $zip = new ZipArchive;
                    if ($zip->open($path . $filename) === TRUE) {
                        $zip->extractTo($path);
                        $zip->close();

                        $file_location = substr($path . $filename, 0, strlen($path . $filename) - 4);
                        $file_location = $file_location . '/database.sql';
                        $sql = file_get_contents($file_location, true);
                        $sqls = explode(';', $sql);
                        array_pop($sqls);

                        foreach ($sqls as $statement) {
                            $statement = $statement . ";";
                            $this->db->query($statement);
                        }
                        unlink($file_location);
                        echo "Update Finished";
                        //update_php($file_location);
                    } else {
                        echo 'failed';
                    }
                }
            }
        } else if ((strpos($_FILES["file"]["name"], 'sql')) || (strpos($_FILES["file"]["name"], 'SQL'))) {
            if ($_FILES["file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
            } else {
                $filename = $_FILES["file"]["name"];
                if (file_exists($path . $filename)) {
                    echo $filename . " already exists. ";
                } else {
                    move_uploaded_file($_FILES["file"]["tmp_name"], $path . $filename);
                    $sql = file_get_contents($path . $filename, true);
                    $sqls = explode(';', $sql);
                    array_pop($sqls);

                    foreach ($sqls as $statement) {
                        $statement = $statement . ";";
                        $this->db->query($statement);
                    }
                    unlink($path . $filename);
                    echo "Update Finished";
                }
            }
        } else {
            echo "Invalid file, only allow zip file";
        }
    }

    private function update_mysql($file_path) {

        $sql_file_name = $file_path . '/database.sql';
        $sql = file_get_contents($sql_file_name, true);
        $sqls = explode(';', $sql);
        array_pop($sqls);

        foreach ($sqls as $statement) {
            $statement = $statement . ";";
            $this->db->query($statement);
        }
        unlink($file_path); //delete after use
    }

    private function update_php($file_path) {
        $source = $file_path . "/application";
        $dst = "./application/";
        //echo "mv $source $dst";
        copy("$source/.", $dst);
        //$output = shell_exec(escapeshellcmd("cp -a $source/. $dst"));
        $output = shell_exec("cp -a $source/. $dst");
        echo 'Update Finished';
        unlink($file_path . ".zip");
        unlink($file_path);

        //$this->rcopy($file_path."/application", $dst);
        //$this->recurse_copy($file_path, $dst);
    }

    function backup_php() {
        // Get real path for our folder
        $cong = array('application', 'public');

        for ($i = 0; $i < count($cong); $i++) {

            $path_zip = 'backup/' . $cong[$i] . '_' . date("Y-m-d") . '.zip';


            $rootPath = realpath($cong[$i]);

            // Initialize archive object
            $zip = new ZipArchive();
            $zip->open($path_zip, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            // Create recursive directory iterator
            /** @var SplFileInfo[] $files */
            $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                // Skip directories (they would be added automatically)
                if (!$file->isDir()) {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($rootPath) + 1);

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }

            // Zip archive will be created only after closing object
            $zip->close();
        }
    }

}
