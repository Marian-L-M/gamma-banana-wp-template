<?php
require_once plugin_dir_path(__FILE__) . "getGlossary.php";
$getGlossary = new getGlossary();
get_header();
?>

<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url();"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">Dramatis Personae</h1>
        <div class="page-banner__intro">
            <p>All the characters and their favorite food</p>
        </div>
    </div>
</div>
<div class="container container--narrow page-section">
    <p>This page took <strong><?php echo timer_stop(); ?></strong> seconds to prepare. Found <strong>x</strong> results
        (showing the first x).</p>
    <table class="glossary">
        <tr>
            <th>Title</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Species</th>
            <th>Score</th>
            <th>Birth Year</th>
            <th>Profession</th>
            <th>Faction</th>
            <th>Favorite Food</th>
        </tr>
        <?php foreach ($getGlossary->glossary as $glossary_entry): ?>
        <tr>
            <td><?php echo $glossary_entry->title_name; ?></td>
            <td><?php echo $glossary_entry->first_name; ?></td>
            <td><?php echo $glossary_entry->last_name; ?></td>
            <td><?php echo $glossary_entry->species; ?></td>
            <td><?php echo $glossary_entry->score; ?></td>
            <td><?php echo $glossary_entry->birthyear; ?></td>
            <td><?php echo $glossary_entry->profession; ?></td>
            <td><?php echo $glossary_entry->faction; ?></td>
            <td><?php echo $glossary_entry->favfood; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>

<?php get_footer(); ?>
