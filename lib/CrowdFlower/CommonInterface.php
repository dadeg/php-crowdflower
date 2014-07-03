<?php

namespace CrowdFlower;

interface CommonInterface
{
  public function read($id);
  public function create($data);
  public function update($id, $data);
  public function delete($id);
}
