<?php

namespace CustomerManagementFrameworkBundle\Model\AbstractCustomer;

use App\Model\AbstractModel;

// This is a temporary bridge class that serves for compatibility until properly updating dependencies
abstract class DefaultAbstractUserawareCustomer extends AbstractModel
{
    public abstract function getGender(): ?string;
    public abstract function setGender(?string $gender): static;
    public abstract function getStreet(): ?string;
    public abstract function setStreet(?string $street): static;
    public abstract function getZip(): ?string;
    public abstract function setZip(?string $zip): static;
    public abstract function getCity(): ?string;
    public abstract function setCity(?string $city): static;
    public abstract function getCountryCode(): ?string;
    public abstract function setCountryCode(?string $countryCode): static;
    public abstract function getIdEncoded(): ?string;
    public abstract function setIdEncoded(?string $idEncoded): void;
}
