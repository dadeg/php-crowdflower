<?php

namespace CrowdFlower;

/**
 * /jobs/upload
 * /jobs/{job_id}/upload
 *
 */
class Job extends CrowdFlower implements CommonInterface
{

  public function read($id){
    $this->sendRequest("get", "jobs/".$id);
  }
  public function create($data){
    $this->sendRequest("post", "jobs/", $data);
  }
  public function update($id, $data);
  public function delete($id);
  public function upload($data, $id=0);


}
