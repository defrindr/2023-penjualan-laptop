<?php

namespace App\Helpers;

class LaptopConstant
{
  const MANUFACTUR_TYPE_APPLE     = 'Apple';
  const MANUFACTUR_TYPE_HP        = 'HP';
  const MANUFACTUR_TYPE_ACER      = 'Acer';
  const MANUFACTUR_TYPE_ASUS      = 'Asus';
  const MANUFACTUR_TYPE_DELL      = 'Dell';
  const MANUFACTUR_TYPE_LENOVO    = 'Lenovo';
  const MANUFACTUR_TYPE_CHUWI     = 'Chuwi';
  const MANUFACTUR_TYPE_MSI       = 'MSI';
  const MANUFACTUR_TYPE_MICROSOFT = 'Microsoft';
  const MANUFACTUR_TYPE_TOSHIBA   = 'Toshiba';
  const MANUFACTUR_TYPE_HHAWEI    = 'Huawei';
  const MANUFACTUR_TYPE_XIAOMI    = 'Xiaomi';
  const MANUFACTUR_TYPE_VERO      = 'Vero';
  const MANUFACTUR_TYPE_RAZER     = 'Razer';
  const MANUFACTUR_TYPE_MEDIACOM  = 'Mediacom';
  const MANUFACTUR_TYPE_SAMSUNG   = 'Samsung';
  const MANUFACTUR_TYPE_GOOGLE    = 'Google';
  const MANUFACTUR_TYPE_FUJITSU   = 'Fujitsu';
  const MANUFACTUR_TYPE_LG        = 'LG';


  const CATEGORY_ULTRABOOK = 'Ultrabook';
  const CATEGORY_NOTEBOOK = 'Notebook';
  const CATEGORY_NETBOOK = 'Netbook';
  const CATEGORY_GAMING = 'Gaming';
  const CATEGORY_2_IN_1_CONVERTIBLE = '2 in 1 Convertible';
  const CATEGORY_WORKSTATION = 'Workstation';


  public static function  listManufacturers()
  {
    return [
      self::MANUFACTUR_TYPE_APPLE     => self::MANUFACTUR_TYPE_APPLE,
      self::MANUFACTUR_TYPE_HP        => self::MANUFACTUR_TYPE_HP,
      self::MANUFACTUR_TYPE_ACER      => self::MANUFACTUR_TYPE_ACER,
      self::MANUFACTUR_TYPE_ASUS      => self::MANUFACTUR_TYPE_ASUS,
      self::MANUFACTUR_TYPE_DELL      => self::MANUFACTUR_TYPE_DELL,
      self::MANUFACTUR_TYPE_LENOVO    => self::MANUFACTUR_TYPE_LENOVO,
      self::MANUFACTUR_TYPE_CHUWI     => self::MANUFACTUR_TYPE_CHUWI,
      self::MANUFACTUR_TYPE_MSI       => self::MANUFACTUR_TYPE_MSI,
      self::MANUFACTUR_TYPE_MICROSOFT => self::MANUFACTUR_TYPE_MICROSOFT,
      self::MANUFACTUR_TYPE_TOSHIBA   => self::MANUFACTUR_TYPE_TOSHIBA,
      self::MANUFACTUR_TYPE_HHAWEI    => self::MANUFACTUR_TYPE_HHAWEI,
      self::MANUFACTUR_TYPE_XIAOMI    => self::MANUFACTUR_TYPE_XIAOMI,
      self::MANUFACTUR_TYPE_VERO      => self::MANUFACTUR_TYPE_VERO,
      self::MANUFACTUR_TYPE_RAZER     => self::MANUFACTUR_TYPE_RAZER,
      self::MANUFACTUR_TYPE_MEDIACOM  => self::MANUFACTUR_TYPE_MEDIACOM,
      self::MANUFACTUR_TYPE_SAMSUNG   => self::MANUFACTUR_TYPE_SAMSUNG,
      self::MANUFACTUR_TYPE_GOOGLE    => self::MANUFACTUR_TYPE_GOOGLE,
      self::MANUFACTUR_TYPE_FUJITSU   => self::MANUFACTUR_TYPE_FUJITSU,
      self::MANUFACTUR_TYPE_LG        => self::MANUFACTUR_TYPE_LG,
    ];
  }

  public static function listCategories()
  {
    return [
      self::CATEGORY_ULTRABOOK          => self::CATEGORY_ULTRABOOK,
      self::CATEGORY_NOTEBOOK           => self::CATEGORY_NOTEBOOK,
      self::CATEGORY_NETBOOK            => self::CATEGORY_NETBOOK,
      self::CATEGORY_GAMING             => self::CATEGORY_GAMING,
      self::CATEGORY_2_IN_1_CONVERTIBLE => self::CATEGORY_2_IN_1_CONVERTIBLE,
      self::CATEGORY_WORKSTATION        => self::CATEGORY_WORKSTATION,
    ];
  }
}
