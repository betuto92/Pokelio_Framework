
    <script>
    <?php
    echo "\t//Pokelio JS Vars Enabler\n";
    foreach($jsVars as $key=>$value){
        echo "\tvar ".$key." = ".$value.";\n";
    }        
    ?>
    </script>    
