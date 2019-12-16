<?php
/**
 * Main content for geo tagging, weather checking.
 */
namespace Anax\View
?>
<html>
    <article>
        <h2>Weather Check</h2>
        <p>Enter a address or IP:</p>
        <form>
            <input type="text" name="search" value="<?= $search ?>">
            <label><input type="radio" name="when" value="future">Coming 7 days</label>
            <label><input type="radio" name="when" value="past">Past 30 days</label>
            <input type="submit" value="Check Weather" name="submit">
            <input type="button" onclick="window.location='http://www.student.bth.se/~lyco18/dbwebb-kurser/ramverk1/me/redovisa/htdocs/geotojson?search=<?=$search?>&when=<?=$when?>'" class="register" value="To JSON"/>
        </form>

        <br>Valid: <?= $valid ?>

        <table>
            <tr>
                <th>Latitude</th>
                <th>Longitude</th>
            </tr>
            <tr>
                <td><?= $lat ?></td>
                <td><?= $long ?></td>
            </tr>
        </table>

        <table>
            <tr>
                <th>When</th>
                <th>Weather</th>
                <th>Temperature</th>
            </tr>
            <!-- <p><?= print_r($time) ?> </p> -->

            <?php for ($i = 0; $i < count($time); $i++) { ?>
            <tr>
                 <td><?php echo $time[$i]; ?></td>
                 <td><?php echo $weather[$i]; ?></td>
                 <td><?php echo $temp[$i]; ?> °C</td>
            </tr>
            <?php } ?>
        </table>

        <a href="https://darksky.net/poweredby/">Powered by DarkSky</a><br><br>

        <iframe width="70%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=<?=$long+0.2?>%2C<?=$lat+0.2?>%2C<?=$long-0.2?>%2C<?=$lat-0.2?>&amp;layer=mapnik&amp;marker=<?=$lat?>%2C<?=$long?>" style="border: 1px solid black"></iframe><br/><small><a href="https://www.openstreetmap.org/#map=12/<?=$lat?>/<?=$long?>">Click for larger maps</a></small>

    </article>
</html>
