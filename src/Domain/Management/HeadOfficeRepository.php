<?php


namespace App\Domain\Management;

interface HeadOfficeRepository
{
    public function instance(): HeadOffice;

    public function save(HeadOffice $headOffice): void;
}