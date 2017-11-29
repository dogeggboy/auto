<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta name="description" content="description of your site" />
    <meta name="author" content="author of the site" />
    <title>IndustryApp Template</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/bootstrap-responsive.css" />
    <!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic" />-->
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/toastr.css" />
    <link rel="stylesheet" href="css/fullcalendar.css" />
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
    <script src="js/jquery-1.8.3.min.js" ></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.knob.js"></script>
    <script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="js/jquery.sparkline.min.js"></script>
    <script src="js/toastr.js"></script>
    <script src="js/jquery.tablesorter.min.js"></script>
    <script src="js/jquery.peity.min.js"></script>
    <script src="js/fullcalendar.min.js"></script>
    <script src="js/gcal.js"></script>
    <script src="js/setup.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
  <body>
    <div id="in-nav">
      <div class="container">
        <div class="row">
        </div>
      </div>
    </div>
    <div class="page">
      <div class="page-container">
<div class="container">
  <div class="row">
    <div class="span12">
      <h4 class="header"><strong><?php
              require ('index.php');
              echo $title;
              ?></strong></h4>
      <table class="table table-striped sortable">
        <thead>
          <tr>
            <th>#</th>
            <th>名称</th>
            <th>年份</th>
            <th>价格</th>
            <th>国家</th>
            <th>状态</th>
            <th>外色</th>
            <th>内色</th>
            <th>手续</th>
            <th>车号</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $i = 0;
        foreach ($arr as $v) {
            $i++;
            echo "<tr>";
            echo "<td>".$i."</td>";
            echo "<td>".$v[0]."</td>";
            echo "<td>".$v[1]."</td>";
            echo "<td>".$v[3]."</td>";
            echo "<td>".$v[4]."</td>";
            if ($v[5] == "现车") {
                echo "<td><span class=\"label label-success\">".$v[5]."</span></td>";
            } else {
                echo "<td><span class=\"label label-important\">".$v[5]."</span></td>";
            }
            echo "<td>".$v[6]."</td>";
            echo "<td>".$v[7]."</td>";
            echo "<td>".$v[8]."</td>";
            echo "<td>".$v[9]."</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="row">
          <div class="span12">
            <p class="pull-right">元汽</p>
            <p>&copy; 2018</p>
          </div>
        </div>
      </div>
    </footer>
  </body>
</html>