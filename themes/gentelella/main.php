  <?php 
  // Call database
  require_once('admin/connect.ini.php');

  require_once('app/stats.php'); 
  ?>
  <!-- top tiles -->
  <div class="row tile_count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-car"></i> Total Number of OE Parts</span>
      <div class="count red">
 <?php    
          $tNumParts = total_num_parts($db_link); 
          echo number_format($tNumParts); 
 ?>   
      </div>
      <span class="count_bottom"><i class="green">Updated </i> 04/17/2017</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-tags"></i> Parts with Supplier's Prices</span>
      <div class="count green">
  <?php 
        $tNumPartsWithPrices = num_parts_with_prices($db_link); 
        echo number_format($tNumPartsWithPrices); 
  ?>
      </div>
      <span class="count_bottom"><i class="green"><?php echo number_format(($tNumPartsWithPrices/$tNumParts)*100); ?>%</i> Of Total Parts</span>
    </div>

    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top "><i class="fa fa-barcode"></i> Parts without OE Price (US)</span>
      <div class="count ">
  <?php
      $tNumWithoutOEPrice = num_parts_without_info($db_link, 'oe_price_us');
      echo number_format($tNumWithoutOEPrice);
  ?>        
      </div>
      <span class="count_bottom"><i class="green"><?php echo number_format(($tNumWithoutOEPrice/$tNumParts)*100,2); ?>%</i></i> Of Total Parts</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total PO</span>
      <div class="count">50</div>
      <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i></i> UNDER DEVELOPMENT</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Containers</span>
      <div class="count">25</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i>UNDER DEVELOPMENT</span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Back Order</span>
      <div class="count">7,325</div>
      <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i></i>UNDER DEVELOPMENT</span>
    </div>
  </div>
  <!-- /top tiles -->
 <br/>

<?php 
    $numPartsPerMaker = num_parts_by_group($db_link, 'maker');
    $numPartsPerModel = num_parts_by_group($db_link, 'model');
    $numPartsPerPartName = num_parts_by_group($db_link, 'part_name');
?>

<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="x_panel tile fixed_height_520">
        <div class="x_title">
          <h2>Makers</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <p></p>
<?php
        $max = 0;
        $restPart = 0;
        for($i=0; $i<count($numPartsPerMaker); $i++) 
        {
          $partInfo = explode("<<<", $numPartsPerMaker[$i]);
          if($i==0)
            $max = $partInfo[1];
        
          $perBar = number_format(($partInfo[1]/$max)*100);
          if($i<10) 
          {
            echo' <div class="widget_summary">
                    <div class="w_left w_25">
                      <span>'.$partInfo[0].'</span>
                    </div>';
              echo '<div class="w_center w_55">
                      <div class="progress">
                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: '.$perBar.'%;">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </div>';
              echo '<div class="w_right w_20">
                       <span>'.number_format($partInfo[1]).'</span>
                    </div>
                    <div class="clearfix"></div>
                  </div>';
          }else
             $restPart += $partInfo[1];            
        }
        $perBar = number_format(($restPart/$max)*100);
         echo' <div class="widget_summary">
                    <div class="w_left w_25">
                      <span>OTHERS</span>
                    </div>';
              echo '<div class="w_center w_55">
                      <div class="progress">
                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: '.$perBar.'%;">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </div>';
              echo '<div class="w_right w_20">
                       <span>'.number_format($restPart).'</span>
                    </div>
                    <div class="clearfix"></div>
                  </div>';
       
?>                  
        </div><!-- EOF class="x_content" -->
    </div>  
  </div>

  <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="x_panel tile fixed_height_320 overflow_hidden">
        <div class="x_title">
          <h2>Models</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>           
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table class="" style="width:100%">
            <tr>
              <th style="width:37%;">
                <p>Top 5</p>
              </th>
              <th>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                  <p class="">Models</p>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                  <p class="">Percentage</p>
                </div>
              </th>
            </tr>
            <tr>
              <td>
                <canvas class="canvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
              </td>
              <td>
                <table class="tile_info">
                  <tr>
                    <td>
                      <p><i class="fa fa-square purple"></i>RAV4 </p>
                    </td>
                    <td>20%</td>
                  </tr>
                  <tr>
                    <td>
                      <p><i class="fa fa-square red"></i>RX 350 </p>
                    </td>
                    <td>12%</td>
                  </tr>
                  <tr>
                    <td>
                      <p><i class="fa fa-square green"></i>Santa Fe Sport </p>
                    </td>
                    <td>11%</td>
                  </tr>
                  <tr>
                    <td>
                      <p><i class="fa fa-square blue"></i>Accoud SDN </p>
                    </td>
                    <td>9%</td>
                  </tr>
                  <tr>
                    <td>
                      <p><i class="fa fa-square yellow"></i>Amanti </p>
                    </td>
                    <td>8%</td>
                  </tr>
                  <tr>
                    <td>
                      <p><i class="fa fa-square grey"></i>Others </p>
                    </td>
                    <td>48%</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </div>
    </div>
</div>


 <div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="x_panel tile ">
        <div class="x_title">
          <h2>Parts</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
<?php
        $max = 30000;
        $restPart = 0;
        for($i=0; $i<count($numPartsPerPartName); $i++) 
        {
          $partInfo = explode("<<<", $numPartsPerPartName[$i]);
                              
          if($i<10) 
          {
            $perBar = number_format(($partInfo[1]/$max)*100);
            echo' <div class="widget_summary">
                    <div class="w_left w_40">
                      <span>'.$partInfo[0].'</span>
                    </div>';
              echo '<div class="w_center w_40">
                      <div class="progress">
                        <div class="progress-bar bg-red" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: '.$perBar.'%;">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </div>';
              echo '<div class="w_right w_20">
                       <span>'.number_format($partInfo[1]).'</span>
                    </div>
                    <div class="clearfix"></div>
                  </div>';
          }else
             $restPart += $partInfo[1];            
        }

        $perBar = number_format(($restPart/$max)*100);
         echo' <div class="widget_summary">
                    <div class="w_left w_40">
                      <span>OTHERS</span>
                    </div>';
              echo '<div class="w_center w_40">
                      <div class="progress">
                        <div class="progress-bar bg-red" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: '.$perBar.'%;">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </div>';
              echo '<div class="w_right w_20">
                       <span>'.number_format($restPart).'</span>
                    </div>
                    <div class="clearfix"></div>
                  </div>';
       
?>                  


        </div>

      </div>
    </div>
  </div>    
</div>
<!--  
    </div>
  </div>       
</div>
 <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="dashboard_graph">

        <div class="row x_title">
          <div class="col-md-6">
            <h3>Network Activities <small>Graph title sub-title</small></h3>
          </div>
          <div class="col-md-6">
            <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
              <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
            </div>
          </div>
        </div>

        <div class="col-md-9 col-sm-9 col-xs-12">
          <div id="chart_plot_01" class="demo-placeholder"></div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 bg-white">
          <div class="x_title">
            <h2>Top Campaign Performance</h2>
            <div class="clearfix"></div>
          </div>

          <div class="col-md-12 col-sm-12 col-xs-6">
            <div>
              <p>Facebook Campaign</p>
              <div class="">
                <div class="progress progress_sm" style="width: 76%;">
                  <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="80"></div>
                </div>
              </div>
            </div>
            <div>
              <p>Twitter Campaign</p>
              <div class="">
                <div class="progress progress_sm" style="width: 76%;">
                  <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="60"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-sm-12 col-xs-6">
            <div>
              <p>Conventional Media</p>
              <div class="">
                <div class="progress progress_sm" style="width: 76%;">
                  <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="40"></div>
                </div>
              </div>
            </div>
            <div>
              <p>Bill boards</p>
              <div class="">
                <div class="progress progress_sm" style="width: 76%;">
                  <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="clearfix"></div>
      </div>
    </div>

 </div>

<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Recent Activities <small>Sessions</small></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Settings 1</a>
                </li>
                <li><a href="#">Settings 2</a>
                </li>
              </ul>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <div class="dashboard-widget-content">

            <ul class="list-unstyled timeline widget">
              <li>
                <div class="block">
                  <div class="block_content">
                    <h2 class="title">
                                      <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                  </h2>
                    <div class="byline">
                      <span>13 hours ago</span> by <a>Jane Smith</a>
                    </div>
                    <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                    </p>
                  </div>
                </div>
              </li>
              <li>
                <div class="block">
                  <div class="block_content">
                    <h2 class="title">
                                      <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                  </h2>
                    <div class="byline">
                      <span>13 hours ago</span> by <a>Jane Smith</a>
                    </div>
                    <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                    </p>
                  </div>
                </div>
              </li>
              <li>
                <div class="block">
                  <div class="block_content">
                    <h2 class="title">
                                      <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                  </h2>
                    <div class="byline">
                      <span>13 hours ago</span> by <a>Jane Smith</a>
                    </div>
                    <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                    </p>
                  </div>
                </div>
              </li>
              <li>
                <div class="block">
                  <div class="block_content">
                    <h2 class="title">
                                      <a>Who Needs Sundance When You’ve Got&nbsp;Crowdfunding?</a>
                                  </h2>
                    <div class="byline">
                      <span>13 hours ago</span> by <a>Jane Smith</a>
                    </div>
                    <p class="excerpt">Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that could fund your project, and if the buyers liked your flick, they’d pay to Fast-forward and… <a>Read&nbsp;More</a>
                    </p>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
</div>


<div class="col-md-8 col-sm-8 col-xs-12">



    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Visitors location <small>geo-presentation</small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Settings 1</a>
                    </li>
                    <li><a href="#">Settings 2</a>
                    </li>
                  </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="dashboard-widget-content">
                <div class="col-md-4 hidden-small">
                  <h2 class="line_30">125.7k Views from 60 countries</h2>

                  <table class="countries_list">
                    <tbody>
                      <tr>
                        <td>United States</td>
                        <td class="fs15 fw700 text-right">33%</td>
                      </tr>
                      <tr>
                        <td>France</td>
                        <td class="fs15 fw700 text-right">27%</td>
                      </tr>
                      <tr>
                        <td>Germany</td>
                        <td class="fs15 fw700 text-right">16%</td>
                      </tr>
                      <tr>
                        <td>Spain</td>
                        <td class="fs15 fw700 text-right">11%</td>
                      </tr>
                      <tr>
                        <td>Britain</td>
                        <td class="fs15 fw700 text-right">10%</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div id="world-map-gdp" class="col-md-8 col-sm-12 col-xs-12" style="height:230px;"></div>
              </div>
            </div>
          </div>
        </div>

      </div>
     
      <div class="row">


        <!-- Start to do list 
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>To Do List <small>Sample tasks</small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Settings 1</a>
                    </li>
                    <li><a href="#">Settings 2</a>
                    </li>
                  </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <div class="">
                <ul class="to_do">
                  <li>
                    <p>
                      <input type="checkbox" class="flat"> Schedule meeting with new client </p>
                  </li>
                  <li>
                    <p>
                      <input type="checkbox" class="flat"> Create email address for new intern</p>
                  </li>
                  <li>
                    <p>
                      <input type="checkbox" class="flat"> Have IT fix the network printer</p>
                  </li>
                  <li>
                    <p>
                      <input type="checkbox" class="flat"> Copy backups to offsite location</p>
                  </li>
                  <li>
                    <p>
                      <input type="checkbox" class="flat"> Food truck fixie locavors mcsweeney</p>
                  </li>
                  <li>
                    <p>
                      <input type="checkbox" class="flat"> Food truck fixie locavors mcsweeney</p>
                  </li>
                  <li>
                    <p>
                      <input type="checkbox" class="flat"> Create email address for new intern</p>
                  </li>
                  <li>
                    <p>
                      <input type="checkbox" class="flat"> Have IT fix the network printer</p>
                  </li>
                  <li>
                    <p>
                      <input type="checkbox" class="flat"> Copy backups to offsite location</p>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- End to do list
        
        <!-- start of weather widget 
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Daily active users <small>Sessions</small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Settings 1</a>
                    </li>
                    <li><a href="#">Settings 2</a>
                    </li>
                  </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row">
                <div class="col-sm-12">
                  <div class="temperature"><b>Monday</b>, 07:30 AM
                    <span>F</span>
                    <span><b>C</b></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">
                  <div class="weather-icon">
                    <canvas height="84" width="84" id="partly-cloudy-day"></canvas>
                  </div>
                </div>
                <div class="col-sm-8">
                  <div class="weather-text">
                    <h2>Texas <br><i>Partly Cloudy Day</i></h2>
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="weather-text pull-right">
                  <h3 class="degrees">23</h3>
                </div>
              </div>

              <div class="clearfix"></div>

              <div class="row weather-days">
                <div class="col-sm-2">
                  <div class="daily-weather">
                    <h2 class="day">Mon</h2>
                    <h3 class="degrees">25</h3>
                    <canvas id="clear-day" width="32" height="32"></canvas>
                    <h5>15 <i>km/h</i></h5>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="daily-weather">
                    <h2 class="day">Tue</h2>
                    <h3 class="degrees">25</h3>
                    <canvas height="32" width="32" id="rain"></canvas>
                    <h5>12 <i>km/h</i></h5>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="daily-weather">
                    <h2 class="day">Wed</h2>
                    <h3 class="degrees">27</h3>
                    <canvas height="32" width="32" id="snow"></canvas>
                    <h5>14 <i>km/h</i></h5>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="daily-weather">
                    <h2 class="day">Thu</h2>
                    <h3 class="degrees">28</h3>
                    <canvas height="32" width="32" id="sleet"></canvas>
                    <h5>15 <i>km/h</i></h5>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="daily-weather">
                    <h2 class="day">Fri</h2>
                    <h3 class="degrees">28</h3>
                    <canvas height="32" width="32" id="wind"></canvas>
                    <h5>11 <i>km/h</i></h5>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="daily-weather">
                    <h2 class="day">Sat</h2>
                    <h3 class="degrees">26</h3>
                    <canvas height="32" width="32" id="cloudy"></canvas>
                    <h5>10 <i>km/h</i></h5>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>

        </div>
        <!-- end of weather widget 
      </div>
    </div>
</div>
-->
	