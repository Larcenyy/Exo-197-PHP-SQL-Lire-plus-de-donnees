<?php

class DbPDO
{
    private static string $server = 'localhost';
    private static string $username = 'root';
    private static string $password = '';
    private static string $database = 'colyseum';
    private static ?PDO $db = null;

    public static function connect(): ?PDO {
        if (self::$db == null){
            try {
                self::$db = new PDO("mysql:host=".self::$server.";dbname=".self::$database, self::$username, self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $request = self::$db->prepare("SELECT * from clients ORDER BY id ASC");
                $start = $request->execute();

                $show = self::$db->prepare("SELECT * from showtypes ORDER BY id ASC");
                $start = $show->execute();

                $maxClient = self::$db->prepare("SELECT * from clients ORDER BY id ASC LIMIT 20");
                $start = $maxClient->execute();

                $fidel = self::$db->prepare("SELECT * from clients WHERE card = 1");
                $start = $fidel->execute();

                $letterM = self::$db->prepare("SELECT * from clients WHERE lastName LIKE 'M%' ORDER BY lastName ASC");
                $start = $letterM->execute();

                $concert = self::$db->prepare("SELECT * from shows ORDER BY id ASC");
                $start = $concert->execute();

                $name = self::$db->prepare("SELECT * from clients ORDER BY id ASC");
                $start = $name->execute();

                if ($start) {
                    echo "<div class='container'>";
                    foreach ($request as $value) {
                        echo "<p>Clients ID =" . $value['id'] . " / Nom : " . $value['lastName'] . " Prénom : " . $value['firstName'] . " Anniversaire : " . $value['birthDate'] . "<br> </p>";
                    }
                    echo "</div>";
////////////////////////////////////////////////////////////////////////////
                    echo "<div class='container showType'>";
                    foreach ($show as $value) {
                        echo "<p> Type de spectable = " . $value['type'] . "</p>";
                    }
                    echo "</div>";
////////////////////////////////////////////////////////////////////////////
                    echo "<div class='container showType'>";
                    foreach ($maxClient as $value) {
                        echo "<p>Clients ID =" . $value['id'] . " / Nom : " . $value['lastName'] . " Prénom : " . $value['firstName'] . " Anniversaire : " . $value['birthDate'] . "<br> </p>";
                    }
                    echo "</div>";
////////////////////////////////////////////////////////////////////////////
                    echo "<div class='container showType'>";
                    foreach ($fidel as $value) {
                        echo "<p>Clients  = " . " / Nom : " . $value['lastName'] . " Prénom : " . $value['firstName'] . "Possède une carte de fidélité" . "<br> </p>";
                    }
                    echo "</div>";
////////////////////////////////////////////////////////////////////////////
                    echo "<div class='container showType'>";
                    foreach ($letterM as $value) {
                        echo "<p>Clients  = " . " / Nom : " . $value['lastName'] . " Prénom : " . $value['firstName'] . "<br> </p>";
                    }
                    echo "</div>";
////////////////////////////////////////////////////////////////////////////
                    echo "<div class='container showType'>";
                    foreach ($concert as $value) {
                        echo "<p>" . $value['title'] . " par " . $value['performer'] . " le " . $value["date"] . " à " . $value["startTime"];
                    }
                    echo "</div>";
////////////////////////////////////////////////////////////////////////////
                    echo "<div class='container showType'>";
                    foreach ($name as $value) {
                        echo "<p>";
                        echo "Nom " . $value["lastName"] . "<br>";
                        echo "Prénom " . $value["firstName"] . "<br>";
                        echo "Date de naissance " . $value["birthDate"] . "<br>";
                        if ($value["card"]){
                            echo "Oui" . "<br>";
                        } else{
                            echo "Non" . "<br>";
                        }
                        echo "Numéro de carte " . $value["cardNumber"] . "<br>";
                        echo "</p>";
                    }
                }
                else{
                    echo "Erreur";
                }
            }
            catch (PDOException $e) {
                echo "Erreur de la connexion à la dn : " . $e->getMessage();
                die();
            }
        }
        return self::$db;

    }
}
