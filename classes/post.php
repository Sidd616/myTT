<?php
class Post
{
      private $error = "";
      public function add_project($userid, $data)
      {
            if (!empty($data['pro_name'])) {
                  $pro_name = addslashes($data['pro_name']);
                  $projectid = $this->create_postid();

                  $query = "insert into project (project_id, project_name, dept_id) values ('$projectid', '$pro_name', '$userid')";

                  $DB = new Database();
                  $DB->save($query);
            } else {
                  $this->error .= "Please Type Something.";
            }

            return $this->error;
      }

      public function get_project($id)
      {
            $query = "select * from project where dept_id = '$id' ";

            $DB = new Database();
            $result = $DB->read($query);

            if ($result) {
                  return $result;
            } else {
                  return false;
            }
      }

      public function project_detail($project_id)
      {
            $query = "select * from project where project_id = '$project_id' limit 1";

            $DB = new Database();
            $result = $DB->read($query);

            if ($result) {
                  return $result[0];
            } else {
                  return false;
            }
      }

      public function project_form($project_id)
      {
            $query = "SELECT * FROM subject WHERE project_id = '$project_id' AND subject_type IN ('ALC', 'Opted') ORDER BY `subject_type` ASC";

            $DB = new Database();
            $result = $DB->read($query);

            if ($result) {
                  return $result;
            } else {
                  return false;
            }
      }

      public function add_subject($project_id, $data)
      {
            if (!empty($data['sub_name']) && !empty($data['sub_type'])) {
                  $sub_name = addslashes($data['sub_name']);
                  $sub_type = addslashes($data['sub_type']);
                  $subject_id = $this->create_postid();

                  $query = "insert into subject (subject_id, subject_name, subject_type, project_id) values ('$subject_id','$sub_name','$sub_type','$project_id')";

                  $DB = new Database();
                  $DB->save($query);
            } else {
                  $this->error .= "Invalid Input.";
            }

            return $this->error;
      }

      public function get_subject($project_id)
      {
            $query = "select * from subject where project_id = '$project_id' ";

            $DB = new Database();
            $result = $DB->read($query);

            if ($result) {
                  return $result;
            } else {
                  return false;
            }
      }

      public function subject_detail($subject_id)
      {
            $query = "select * from subject where subject_id = '$subject_id' limit 1";

            $DB = new Database();
            $result = $DB->read($query);

            if ($result) {
                  return $result[0];
            } else {
                  return false;
            }
      }

      private function create_postid()
      {

            $length = rand(4, 19);
            $number = "";
            for ($i = 0; $i < $length; $i++) {
                  # code...
                  $new_rand = rand(0, 9);

                  $number = $number . $new_rand;
            }

            return $number;
      }
}
