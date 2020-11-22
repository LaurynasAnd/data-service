<?php

namespace App\Entity;

use App\Repository\ServerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServerRepository::class)
 */
class Server
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $client;

    /**
     * @ORM\Column(type="smallint")
     */
    private $sign_smartid;

    /**
     * @ORM\Column(type="smallint")
     */
    private $sign_mobile;

    /**
     * @ORM\Column(type="smallint")
     */
    private $sign_sc;

    /**
     * @ORM\Column(type="smallint")
     */
    private $authorize_smartid;

    /**
     * @ORM\Column(type="smallint")
     */
    private $authorize_mobile;

    /**
     * @ORM\Column(type="smallint")
     */
    private $authorize_sc;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ocsp;

    /**
     * @ORM\Column(type="smallint")
     */
    private $crl;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getSignSmartid(): ?int
    {
        return $this->sign_smartid;
    }

    public function setSignSmartid(int $sign_smartid): self
    {
        $this->sign_smartid = $sign_smartid;

        return $this;
    }

    public function getSignMobile(): ?int
    {
        return $this->sign_mobile;
    }

    public function setSignMobile(int $sign_mobile): self
    {
        $this->sign_mobile = $sign_mobile;

        return $this;
    }

    public function getSignSc(): ?int
    {
        return $this->sign_sc;
    }

    public function setSignSc(int $sign_sc): self
    {
        $this->sign_sc = $sign_sc;

        return $this;
    }

    public function getAuthorizeSmartid(): ?int
    {
        return $this->authorize_smartid;
    }

    public function setAuthorizeSmartid(int $authorize_smartid): self
    {
        $this->authorize_smartid = $authorize_smartid;

        return $this;
    }

    public function getAuthorizeMobile(): ?int
    {
        return $this->authorize_mobile;
    }

    public function setAuthorizeMobile(int $authorize_mobile): self
    {
        $this->authorize_mobile = $authorize_mobile;

        return $this;
    }

    public function getAuthorizeSc(): ?int
    {
        return $this->authorize_sc;
    }

    public function setAuthorizeSc(int $authorize_sc): self
    {
        $this->authorize_sc = $authorize_sc;

        return $this;
    }

    public function getOcsp(): ?int
    {
        return $this->ocsp;
    }

    public function setOcsp(int $ocsp): self
    {
        $this->ocsp = $ocsp;

        return $this;
    }

    public function getCrl(): ?int
    {
        return $this->crl;
    }

    public function setCrl(int $crl): self
    {
        $this->crl = $crl;

        return $this;
    }
}
