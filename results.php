<?php
require 'includes/config.php';

$searchQuery = !empty($_GET['q'])? htmlspecialchars($_GET['q'], ENT_QUOTES, 'utf-8'): '';

// $data = require('includes/data.php');
//Get them to call the function to grab all website rows and pass through the database connection.

// $data = getWebsiteTable($dbh);
// die(var_dump($data));
$terms = [];

if (!empty($searchQuery)) {
  // Do like query for $search
   $terms = searchWebsiteTable($dbh, $searchQuery);
}

if($searchQuery == 'nodoodlesfound'){
  $searchQuery = '';
  $terms = getWebsiteTable($dbh);
  // $terms = require('includes/data.php');
}

if($searchQuery == 'doodles'){
  $terms = getRandomResultUsingSQL($dbh);

  $searchQuery = $terms[0]['text'];
}

include 'partials/header.php';
include 'partials/navigation.php';
?>

<!-- Content -->
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <?php
      if($searchQuery !== ''){
        echo '<h4>Search results for <strong>' . $searchQuery . '</strong></h4>';
      }
      ?>
      <!-- Displayed results -->
      <ul class="list-group">
        <?php
        if (empty($terms)):
        ?>
        <li class="list-group-item notification-bar-fail m-b-1">


          <div class="notification-bar-details">
            <h3 class="notification-bar-title">

              No results were found :(<br>
            </h3>
            <p>
              <strong>Suggestions:</strong>
              <ul>
                <li>Make sure that all words are spelled correctly.</li>
                <li>Try different keywords.</li>
                <li>Try more general keywords.</li>
                <li><a href="results.php?q=nodoodlesfound">View all results.</a></li>
              </ul>

            </p>
          </div>
        </li>
        <!-- End of single result -->
        <?php
        else:
        foreach ($terms as $key => $term):
          ?>
        <!-- Single Result -->
        <li class="list-group-item notification-bar-fail m-b-1">

          <div class="notification-bar-details">
            <a href="<?=$term['url']?>" class="notification-bar-title">
              <?=$term['text']?>
            </a>
            <span class="text-muted"><?=$term['url']?></span>
          </div>
        </li>
        <!-- End of single result -->
        <?php
        endforeach;
        endif;
        ?>
      </ul>
    </div>
  </div>
</div>
<?php include 'partials/search-footer.php'; ?>
<?php include 'partials/footer.php'; ?>
