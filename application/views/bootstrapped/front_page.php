<div>
    
    <div>
        <div class="well">
            <h2>Front page for Crudder on-line example</h2>
        </div>

        <?php
        if ($message !== false) {
            echo '<div class="alert alert-success">';
            echo '<b>' . urldecode($message) . '</b>';
            echo "</div>\n";
        }
        ?>
    
        <blockquote>
        <h2>Click <a href="/crudder">here</a> to enter the Crudder</h2>
        <p>This example allows edition of three tables containing data for all the administrative territories
            of Venezuela<br/>(levels: Estados, Municipios, Parroquias).</p>
        <p>Play with it as you want. Each two hours the data will be automatically reset to the original values.</p>
        </blockquote>
    </div>

</div>
