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
    private $title;
    public $email;

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

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($newTitle){
        $this->title = $newTitle;
        return $this;
    }



    
}
