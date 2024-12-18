<?php

namespace App\Controllers;

use MongoDB;// composerla yüklendi
//genel dokümantasyon --> https://www.mongodb.com/docs/php-library/current/get-started/
//veri okuma için dokümantasyon --> https://www.mongodb.com/docs/php-library/current/read/
//veri yazma için dokümantasyon --> https://www.mongodb.com/docs/php-library/current/write/

//mongo kurulum için dokümantasyon --> https://www.mongodb.com/developer/languages/php/php-setup/
//ek bilgi için dokümantasyon --> https://www.mongodb.com/developer/languages/php/php-crud/

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function test($ornek)
    {
        $kul_adi="reew2002";
        $sifre="ShsZT9u97GGAt9zO";
        $adres="cluster0.jm09z.mongodb.net";
        $veritabani="sample_mflix";

        switch ($ornek)
        {
            case 1:{//tek veri sorgulama
                $koleksiyon_adi='users';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $document = $koleksiyon->findOne(['email' => 'sean_bean@gameofthron.es']);
                //var_dump($document);
                foreach ($document as $key => $value)
                {
                    echo $key.' -> '.$value.'<br>';
                }
            }break;
            case 2:{//çoklu veri sorgulama
                $koleksiyon_adi='comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $document = $koleksiyon->find(['email' => 'john_bishop@fakegmail.com']);
                //var_dump($document);
                foreach ($document as $doc) {
                    foreach ($doc as $key => $value)
                    {
                        echo $key.' -> '.$value.'<br>';
                    }
                    echo '<hr>';
                }
            }break;
            case 3:{//koleksiyondaki toplam veri miktarı
                $koleksiyon_adi='users';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $toplam = $koleksiyon->countDocuments([]);

                echo $toplam;
            }break;
            case 4:{//bir sorguyla dönen veri miktarı
                $koleksiyon_adi='comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $toplam = $koleksiyon->countDocuments(['email' => 'john_bishop@fakegmail.com']);

                echo $toplam;
            }break;
            case 5:{//tek bir veri ekleme
                $koleksiyon_adi='comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $sonuc = $koleksiyon->insertOne([
                    'name' => 'Veli Özcan',
                    'email' => 'ozcan@test.com',
                    'text' => 'örnek yorum',
                ]);
                //var_dump($sonuc);
            }break;
            case 6:{//çoklu veri ekleme
                $koleksiyon_adi='comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $sonuc = $koleksiyon->insertMany([
                    [
                        'name' => 'Veli Özcan',
                        'email' => 'ozcan@test.com',
                        'text' => 'örnek yorum',
                    ],
                    [
                        'name' => 'Veli Özcansd',
                        'email' => 'ozcan@test.com',
                        'text' => 'örnek yorum2',
                    ],
                ]);

                //var_dump($sonuc);
            }break;
            case 7:{//tek bir veriyi güncelleme (sorgulamada ilk çıkan veri güncellenir)
                $koleksiyon_adi='comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $sonuc = $koleksiyon->updateOne(
                    [
                        'email' => 'ozcan@test.com'
                    ],
                    ['$set' => ['text' => 'yorum güncellendi']]
                );
            }break;
            case 8:{//çoklu veri güncelleme
                $koleksiyon_adi='comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $sonuc = $koleksiyon->updateMany(
                    [
                        'email' => 'ozcan@test.com'
                    ],
                    ['$set' => ['text' => 'yorum güncellendi']]
                );
            }break;
            case 9:{//tek bir veriyi silme (sorgulamada ilk çıkan veri silinir)
                $koleksiyon_adi='comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $sonuc = $koleksiyon->deleteOne(
                    [
                        //'_id' => new MongoDB\BSON\ObjectId('67519057a2600000f80045d2') //id ile silmek için
                        'email' => 'ozcan@test.com' //normal silme için
                    ]
                );
            }break;
            case 10:{//çoklu veri silme
                $koleksiyon_adi='comments';
                $client = new MongoDB\Client("mongodb+srv://$kul_adi:$sifre@$adres");

                $koleksiyon = $client->selectCollection($veritabani, $koleksiyon_adi);
                $sonuc = $koleksiyon->deleteMany(
                    [
                        'email' => 'ozcan@test.com'
                    ]
                );
            }break;
        }

    }
}
