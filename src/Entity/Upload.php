<?php

namespace App\Entity;

use App\Repository\UploadRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UploadRepository::class)
 */
class Upload
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="string")
     */
    private $id;
    private $file;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getfile(){
        return $this->file;
    }

    public function setfile($newfile){
        $this->file = $newfile;
        return $this;
    }



    
}
