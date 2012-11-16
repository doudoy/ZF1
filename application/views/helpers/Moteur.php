<?php

class Zend_View_Helper_Moteur extends Zend_Search_Lucene_Document {

    public function Moteur($query) {
        
//CREATION DU TABLEAU RECENSANT LES PAGES DE RESULTAT
        //"contents" énumère l'ensemble des mots clés que l'internaute pourrait poster
        $articlesData = array(
//LES TUTOS
            0 => array("url" => "tuto/xmletphp",
                "title" => "XML et PHP",
                "contents" => "Créer un document xml avec php",
                "category" => "TUTO"),
            1 => array("url" => "tuto/zfauth",
                "title" => "ZEND_AUTH",
                "contents" => "Utiliser Zend_auth dans une application modulaire",
                "category" => "TUTO"),
            2 => array("url" => "tuto/zfmodulaire",
                "title" => "Une application ZF modulaire",
                "contents" => "Créer une application modulaire avec ZF",
                "category" => "TUTO"),
            3 => array("url" => "tuto/jquery",
                "title" => "ZENDX_JQUERY :: LES TUTOS",
                "contents" => "ZENDX JQUERY les tutoriels",
                "category" => "TUTO"),
            4 => array("url" => "tuto/accordion",
                "title" => "ZENDX_JQUERY :: ACCORDION",
                "contents" => "ZENDX JQUERY accordeon accordion avec Jquery",
                "category" => "TUTO"),
            5 => array("url" => "tuto/dialogue",
                "title" => "ZENDX_JQUERY :: DIALOG",
                "contents" => "ZENDX JQUERY  boite de dialogue avec Jquery",
                "category" => "TUTO"),
            6 => array("url" => "tuto/tab",
                "title" => "ZENDX_JQUERY :: TABCONTAINER",
                "contents" => "ZENDX JQUERY tab container pane avec Jquery",
                "category" => "TUTO"),
            7 => array("url" => "tuto/datepicker",
                "title" => "ZENDX_JQUERY :: DATEPICKER",
                "contents" => "ZENDX JQUERY date picker datepicker avec Jquery",
                "category" => "TUTO"),
            8 => array("url" => "tuto/paginator",
                "title" => "ZEND_PAGINATOR",
                "contents" => "ZEND_Paginator zend paginator bd select",
                "category" => "TUTO"),
//INFOS DU SITE
            9 => array("url" => "info/navig",
                "title" => "ZEND_NAVIGATION",
                "contents" => "Créer une barre de navigation et son fil d'ariane avec ZEND_NAVIGATION et un fichier XML ",
                "category" => "INFO"),
            10 => array("url" => "info/structure",
                "title" => "Structure du site",
                "contents" => "Controller action bootstrap form model",
                "category" => "INFO"),
            11 => array("url" => "info/moteur",
                "title" => "ZEND_SEARCH_LUCENE",
                "contents" => "Moteur de recherche lucene ",
                "category" => "INFO"),
            12 => array("url" => "info/sitemap",
                "title" => "Sitemap",
                "contents" => "Site map sitemap du site ",
                "category" => "info")
        );

//CREATION DE L'INDEX
        try{
            $index = Zend_Search_Lucene::create('application/data/lucene');
                        //POUR CHAQUE ARTICLE DU TABLEAU
                foreach ($articlesData as $articleData) {
                //CREER UN NOUVEAU DOCUMENT
                $doc = new Zend_Search_Lucene_Document();
                $doc->addField(Zend_Search_Lucene_Field::Keyword('url', $articleData["url"]));
                $doc->addField(Zend_Search_Lucene_Field::Text('title', $articleData["title"]));
                $doc->addField(Zend_Search_Lucene_Field::Text('category', $articleData["category"]));
                $doc->addField(Zend_Search_Lucene_Field::UnStored('contents', $articleData["contents"]));

                //AJOUTER CE DOCUMENT A L'INDEX
                $index->addDocument($doc);
            }
            //EXECUTER l'INDEX
            $index->commit();
            //L'OPTIMISER
            $index->optimize();

        }
        catch(Exception $e){

        }



       
//OUVRIR L'INDEX
        try{
        $index = Zend_Search_Lucene::open("application/data/lucene");
        //Trouver le ou les mots clef saisis dans le moteur
        //(post du moteur de recherche application/forms/moteur.php)
        $results = $index->find($query);
        //AFFICHER LE RESULAT
        if (isset($_POST['mots'])) {
            if ($results) {
                echo "Résultat de la recherche : <br />";
                foreach ($results as $result) {
                    //echo number_format($result->score, 2);
                    echo "<p>".$result->category . " :: ";
                    echo "<a href='" . $result->url . "'>" . $result->title . "</a></p>";
                }
            } else {
                //SI LA REQUETE NE DONNE AUCUN RESULTAT
                echo "Aucun résultat";
            }
        }
        }
        catch(Exception $e){

        }

    }

}

?>
