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
    private $name;
    private $firstname;
    private $email;


    //Zone pour les getteurs et les setteurs
    public function getId(): ?int {
        return $this->id;
    }

    public function getfile(){
        return $this->file;
    }

    public function setfile($newfile){
        $this->file = $newfile;
        return $this;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($newName){
        $this->name = $newName;
        return $this;
    }

    public function getFirstName(){
        return $this->firstname;
    }

    public function setFirstName($newName){
        $this->firstname = $newName;
        return $this;
    }

    public function getEmail() {
		return $this->email;
	}

	public function setEmail($newEmail) {
		$this->email = $newEmail;
	}

    
}
