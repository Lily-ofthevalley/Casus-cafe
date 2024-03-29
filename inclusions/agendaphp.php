<div class="eventList">
        <?php
            require_once "dbh.php";

            try {
                $sqlEvent = "SELECT idEvent, Naam, Entree, Datum, BeginTijd FROM Event";
                $resultEvent = $pdo->query($sqlEvent);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                die();
            }

            if ($resultEvent->rowCount() > 0) {
                while ($row = $resultEvent->fetch(PDO::FETCH_ASSOC))
                {
                    echo "<div class='event'>";
                    echo "<p class='eventName'>".$row["Naam"]."</p>";
                    echo "<div class='eventInfo'>";
                    echo "<p>Datum: ".$row["Datum"]."</p>";
                    echo "<p>Aanvangstijd: ".$row["BeginTijd"]."</p>";
                    echo "<p>Prijs: ".$row["Entree"]. " Euro</p>";
                    echo "</div>";
                    echo "<div class='bandsEvent'>";

                    try {
                        $idEvent = $row["idEvent"];
                        $sqlBands = "SELECT BandNaam, Genre FROM Band b INNER JOIN Event_has_Band eb ON b.idBand = eb.Band_idBand WHERE eb.Event_idEvent = $idEvent";
                        $resultBands = $pdo->query($sqlBands);

                        if ($resultBands->rowCount() > 0){
                            echo "<div>";
                            echo "<p>Artiesten</p>";
                            echo "<ul>";
                            while ($bandRow = $resultBands->fetch(PDO::FETCH_ASSOC)){
                                echo "<li>".$bandRow["BandNaam"]."</li>";
                            }
                            echo "</ul>";
                            echo "</div>";

                            $resultBands = $pdo->query($sqlBands);
                            echo "<div>";
                            echo "<p>Genre</p>";
                            echo "<ul>";
                            while ($bandRow = $resultBands->fetch(PDO::FETCH_ASSOC)){
                                echo "<li>".$bandRow["Genre"]."</li>";
                            }
                            echo "</ul>";
                            echo "</div>";
                        }else{
                            echo "<p>No bands scheduled for this event</p>";
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                        
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No data found</p>";
            }
            ?>
        </div>