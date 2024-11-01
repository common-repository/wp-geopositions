<?php
/*
Plugin Name: GeoPositions
Plugin URI: http://aclog.ionosfera.com/wordpress-plugins/geopositions/
Description: Allow assigning geographic coordinates to places and show them on your post as links to geolocalization services, like Google Maps, Google Earth and others. <a href="../wp-admin/options-general.php?page=wp-geopositions.php">Click here to Manage your Positions</a>
Version: 1.2b
Author: Gregorio Hernandez Caso
Author URI: http://aclog.ionosfera.com
*/

/*  Copyright 2005  Gregorio Hernandez Caso  (email : ioz@ionosfera.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if (!is_plugin_page()) {
  load_plugin_textdomain('ioz_gp');
  $arrGP = array(
    'El Puerto' => array(
      'placename' => 'El Puerto de Santa Mar&iacute;a',
      'latitude' => '36.602325',
      'longitude' => '-6.228561',
      'scale' => '50000'
    )
  );
  add_option('ioz_gp_positions', $arrGP);
  add_option('ioz_gp_show_google_maps', true);
  add_option('ioz_gp_code_google_maps', '<img src="'.get_option('siteurl').'/wp-images/icon_google_maps.gif" alt="Google Maps" style="margin-left:3px;" />');
  add_option('ioz_gp_show_google_earth', true);
  add_option('ioz_gp_code_google_earth', '<img src="'.get_option('siteurl').'/wp-images/icon_google_earth.gif" alt="Google Earth" style="margin-left:3px;" />');
  add_option('ioz_gp_show_multimap', true);
  add_option('ioz_gp_code_multimap', '<img src="'.get_option('siteurl').'/wp-images/icon_multimap.gif" alt="Multimap.com" style="margin-left:3px;" />');
  add_option('ioz_gp_show_msn_ve', true);
  add_option('ioz_gp_code_msn_ve', '<img src="'.get_option('siteurl').'/wp-images/icon_msn_ve.gif" alt="MSN Virtual Earth" style="margin-left:3px;" />');
  unset($arrGP);
  
  function ioz_gp_get_google_maps_link($position_id) {
    $arrGP = get_option('ioz_gp_positions');
    if (isset($arrGP[$position_id])) {
      $sURI = '<a href="http://maps.google.com/maps?ll='.$arrGP[$position_id]['latitude'].','.$arrGP[$position_id]['longitude'].'&spn='.($arrGP[$position_id]['scale']/1442834).','.($arrGP[$position_id]['scale']/830896).'&t=k" title="View position of '.$arrGP[$position_id]['placename'].' in Google Maps">'.stripslashes(get_option('ioz_gp_code_google_maps')).'</a>';
      return $sURI;
    } else {
      return false;
    }
  }
  
  function ioz_gp_get_multimap_link($position_id) {
    $arrGP = get_option('ioz_gp_positions');
    if (isset($arrGP[$position_id])) {
      $sURI = '<a href="http://www.multimap.com/map/browse.cgi?lat='.$arrGP[$position_id]['latitude'].'&lon='.$arrGP[$position_id]['longitude'].'&scale='.$arrGP[$position_id]['scale'].'&icon=x" title="View position of '.$arrGP[$position_id]['placename'].' in MultiMap.com">'.stripslashes(get_option('ioz_gp_code_multimap')).'</a>';
      return $sURI;
    } else {
      return false;
    }
  }
  
  function ioz_gp_get_msn_ve_link($position_id) {
    $arrGP = get_option('ioz_gp_positions');
    if (isset($arrGP[$position_id])) {
      switch ($arrGP[$position_id]['scale']) {
        case 40000000: { $nZoom = 4; break; }
        case 20000000: { $nZoom = 5; break; }
        case 10000000: { $nZoom = 6; break; }
        case 4000000: { $nZoom = 7; break; }
        case 2000000: { $nZoom = 8; break; }
        case 1000000: { $nZoom = 9; break; }
        case 500000: { $nZoom = 10; break; }
        case 200000: { $nZoom = 11; break; }
        case 100000: { $nZoom = 12; break; }
        case 50000: { $nZoom = 13; break; }
        case 25000: { $nZoom = 14; break; }
        case 10000: { $nZoom = 15; break; }
        case 5000: { $nZoom = 16; break; }
        default: { $nZoom = 10; break; }
      }
      $sURI = '<a href="http://virtualearth.msn.com/default.aspx?cp='.$arrGP[$position_id]['latitude'].'|'.$arrGP[$position_id]['longitude'].'&style=r&lvl='.$nZoom.'&v=1" title="View position of '.$arrGP[$position_id]['placename'].' in MSN Virtual Earth">'.stripslashes(get_option('ioz_gp_code_msn_ve')).'</a>';
      return $sURI;
    } else {
      return false;
    }
  }
  
  function ioz_gp_get_google_earth_link($position_id) {
    $arrGP = get_option('ioz_gp_positions');
    if (isset($arrGP[$position_id])) {
      //$sURI = '<a href="'.get_option('siteurl').'/wp-geopositions-file.php?type=google_earth&id='.$position_id.'" title="View position of '.$arrGP[$position_id]['placename'].' in Google Earth">GE</a>';
      $sURI = '<a href="'.get_option('siteurl').'/wp-geopositions-file.php?type=google_earth&id='.$position_id.'" title="View position of '.$arrGP[$position_id]['placename'].' in Google Earth">'.stripslashes(get_option('ioz_gp_code_google_earth')).'</a>';
      return $sURI;
    } else {
      return false;
    }
  }
  
  function ioz_gp_get_position_file($position_id, $type = 'google_earth') {
    $arrGP = get_option('ioz_gp_positions');
    if (isset($arrGP[$position_id])) {
      switch ($type) {
        case 'google_earth': {
          $filename = sanitize_title_with_dashes($position_id).".kml";
          header('Content-type: text/kml; charset=UTF-8', true);
          header('Content-Disposition: attachment; filename="'.$filename.'"');
          echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<kml xmlns="http://earth.google.com/kml/2.0">
<Placemark>
  <name><?php echo $arrGP[$position_id]['placename']; ?></name>
  <LookAt>
    <longitude><?php echo $arrGP[$position_id]['longitude']; ?></longitude>
    <latitude><?php echo $arrGP[$position_id]['latitude']; ?></latitude>
    <range><?php echo ($arrGP[$position_id]['scale'] / 10); ?></range>
    <tilt>0.7</tilt>
    <heading>7</heading>
  </LookAt>
  <visibility>0</visibility>
  <styleUrl>root://styles#default</styleUrl>
  <Point>
    <coordinates><?php echo $arrGP[$position_id]['longitude'].','.$arrGP[$position_id]['latitude']; ?>,0</coordinates>
  </Point>
</Placemark>
</kml>
<?php
          break;
        }
      }
    }
  }
  
  function ioz_gp_replacer($text) {   
    $text = " $text ";
    $arrGP = get_option('ioz_gp_positions');
    
    // Replace positions tags with links
    foreach($arrGP as $thePosition => $thePositionData) {
      $sLinks = '';
      
      if (get_option('ioz_gp_show_google_maps')) {
        $sLinks .= ioz_gp_get_google_maps_link($thePosition);
      }
      if (get_option('ioz_gp_show_google_earth')) {
        $sLinks .= ioz_gp_get_google_earth_link($thePosition);
      }
      if (get_option('ioz_gp_show_multimap')) {
        $sLinks .= ioz_gp_get_multimap_link($thePosition);
      }
      if (get_option('ioz_gp_show_msn_ve')) {
        $sLinks .= ioz_gp_get_msn_ve_link($thePosition);
      }
      
      $text = preg_replace('/\[GP:'.$thePosition.'\]/', $sLinks, $text);
    }
    // Clean unidentified positions
    $text = preg_replace('/\[GP:.*\]/', '', $text);
    
    return trim( $text );
  }
  
  function ioz_gp_add_options_page() {
    add_options_page("GeoPositions", "GeoPositions", 9, "wp-geopositions.php");
  }
  
  add_action('admin_head', 'ioz_gp_add_options_page');
  add_filter('the_content', 'ioz_gp_replacer', 8);
} else {
  $location = get_option('siteurl') . '/wp-admin/admin.php?page=wp-geopositions.php'; // Form Action URI
  
  if (isset($_POST['ioz_gp_action'])) {
    switch ($_POST['ioz_gp_action']) {
      case 'save_options': {
        if(isset($_POST['ioz_gp_show_google_maps'])) {
          update_option('ioz_gp_show_google_maps', true);
        } else {
          update_option('ioz_gp_show_google_maps', false);
        }
        update_option('ioz_gp_code_google_maps', $_POST['ioz_gp_code_google_maps']);
        if(isset($_POST['ioz_gp_show_google_earth'])) {
          update_option('ioz_gp_show_google_earth', true);
        } else {
          update_option('ioz_gp_show_google_earth', false);
        }
        update_option('ioz_gp_code_google_earth', $_POST['ioz_gp_code_google_earth']);
        if(isset($_POST['ioz_gp_show_multimap'])) {
          update_option('ioz_gp_show_multimap', true);
        } else {
          update_option('ioz_gp_show_multimap', false);
        }
        update_option('ioz_gp_code_multimap', $_POST['ioz_gp_code_multimap']);
        if(isset($_POST['ioz_gp_show_msn_ve'])) {
          update_option('ioz_gp_show_msn_ve', true);
        } else {
          update_option('ioz_gp_show_msn_ve', false);
        }
        update_option('ioz_gp_code_msn_ve', $_POST['ioz_gp_code_msn_ve']);
        break;
      }
      case 'add_position': {
        $ioz_gp_positions = get_option('ioz_gp_positions');
        $ioz_gp_positions[$_POST['ioz_gp_position_id']] = array(
          'placename' => $_POST['ioz_gp_position_place_name'],
          'latitude' => $_POST['ioz_gp_position_latitude'],
          'longitude' => $_POST['ioz_gp_position_longitude'],
          'scale' => $_POST['ioz_gp_position_scale']
        );
        ksort($ioz_gp_positions);
        reset($ioz_gp_positions);
        update_option('ioz_gp_positions', $ioz_gp_positions);
        unset($ioz_gp_positions);
        break;
      }
      case 'update_positions': {
        foreach ($_POST['ioz_gp_position_id'] as $ioz_gp_position_id => $ioz_gp_position_key) {
          $ioz_gp_positions[$_POST['ioz_gp_position_id'][$ioz_gp_position_id]] = array(
            'placename' => $_POST['ioz_gp_position_place_name'][$ioz_gp_position_id],
            'latitude' => $_POST['ioz_gp_position_latitude'][$ioz_gp_position_id],
            'longitude' => $_POST['ioz_gp_position_longitude'][$ioz_gp_position_id],
            'scale' => $_POST['ioz_gp_position_scale'][$ioz_gp_position_id]
          );
        }
        ksort($ioz_gp_positions);
        reset($ioz_gp_positions);
        update_option('ioz_gp_positions', $ioz_gp_positions);
        unset($ioz_gp_positions);
        break;
      }
    }
  }
  
	if (isset($_GET['ioz_gp_action']) && $_GET['ioz_gp_action'] == 'delete_position'){
    $ioz_gp_positions = get_option('ioz_gp_positions');
    foreach ($ioz_gp_positions as $ioz_gp_positions_key => $ioz_gp_positions_data) {
      if ($ioz_gp_positions_key != $_GET['ioz_gp_position_id']) {
        $ioz_gp_positions_new[$ioz_gp_positions_key] = $ioz_gp_positions_data;
      }
    }
    ksort($ioz_gp_positions_new);
    reset($ioz_gp_positions_new);
    update_option('ioz_gp_positions', $ioz_gp_positions_new);
    unset($ioz_gp_positions);
    unset($ioz_gp_positions_new);
	}
  
  //$ioz_dl_user_id = stripslashes(get_option('ioz_dl_user_id'));
  $ioz_gp_positions = get_option('ioz_gp_positions');
  $ioz_gp_show_google_maps = get_option('ioz_gp_show_google_maps');
  $ioz_gp_code_google_maps = htmlspecialchars(stripslashes(get_option('ioz_gp_code_google_maps')));
  $ioz_gp_show_google_earth = get_option('ioz_gp_show_google_earth');
  $ioz_gp_code_google_earth = htmlspecialchars(stripslashes(get_option('ioz_gp_code_google_earth')));
  $ioz_gp_show_multimap = get_option('ioz_gp_show_multimap');
  $ioz_gp_code_multimap = htmlspecialchars(stripslashes(get_option('ioz_gp_code_multimap')));
  $ioz_gp_show_msn_ve = get_option('ioz_gp_show_msn_ve');
  $ioz_gp_code_msn_ve = htmlspecialchars(stripslashes(get_option('ioz_gp_code_msn_ve')));

  ksort($ioz_gp_positions);
  reset($ioz_gp_positions);
?>
<script type="text/javascript">
function delete_positon(id) {
  if (confirm('Are you really sure that you want to DELETE the position: '+id+'?\n\nTHIS OPERATION IS NOT UNDOABLE!!!')){
    window.location.href="<?php echo $location; ?>&ioz_gp_action=delete_position&ioz_gp_position_id="+id;
  }
}

function go_to_position(latitude, longitude) {
  document.location.href = "#google_map"
  frames['google_map'].fnDoPan2(latitude, longitude);
}
</script>
<div class="wrap">
  <h2>GeoPositions Configuration</h2>
  <fieldset class="options">
    <legend>Positions</legend>
    <form name="ioz_gp_form_options" method="post" action="<?php echo $location ?>">
      <input type="hidden" name="ioz_gp_action" value="update_positions" />
      <table>
        <tr>
          <th>ID</th>
          <th>Place Name</th>
          <th>Latitude</th>
          <th>Longitude</th>
          <th></th>
          <th>Scale</th>
          <th>Action</th>
          <th>View</th>
        </tr>
        <?php foreach($ioz_gp_positions as $thePosition => $thePositionData) { ?>
        <tr>
          <td><input type="text" size="15" value="<?php echo $thePosition; ?>" name="ioz_gp_position_id[]" /></td>
          <td><input type="text" size="20" value="<?php echo $thePositionData['placename']; ?>" name="ioz_gp_position_place_name[]" /></td>
          <td><input type="text" size="12" value="<?php echo $thePositionData['latitude']; ?>" name="ioz_gp_position_latitude[]" /></td>
          <td><input type="text" size="12" value="<?php echo $thePositionData['longitude']; ?>" name="ioz_gp_position_longitude[]" /></td>
          <td><input type="button" value="&Lambda;" title="Center on Map" onclick="javascript:go_to_position('<?php echo $thePositionData['latitude']; ?>','<?php echo $thePositionData['longitude']; ?>');" /></td>
          <td>
            <select name="ioz_gp_position_scale[]">
              <option value="40000000"<?php echo($thePositionData['scale']==40000000?' selected="selected"':'')?>>1:40,000,000</option>
              <option value="20000000"<?php echo($thePositionData['scale']==20000000?' selected="selected"':'')?>>1:20,000,000</option>
              <option value="10000000"<?php echo($thePositionData['scale']==10000000?' selected="selected"':'')?>>1:10,000,000</option>
              <option value="4000000"<?php echo($thePositionData['scale']==4000000?' selected="selected"':'')?>>1:4,000,000</option>
              <option value="2000000"<?php echo($thePositionData['scale']==2000000?' selected="selected"':'')?>>1:2,000,000</option>
              <option value="1000000"<?php echo($thePositionData['scale']==1000000?' selected="selected"':'')?>>1:1,000,000</option>
              <option value="500000"<?php echo($thePositionData['scale']==500000?' selected="selected"':'')?>>1:500,000</option>
              <option value="200000"<?php echo($thePositionData['scale']==200000?' selected="selected"':'')?>>1:200,000</option>
              <option value="100000"<?php echo($thePositionData['scale']==100000?' selected="selected"':'')?>>1:100,000</option>
              <option value="50000"<?php echo($thePositionData['scale']==50000?' selected="selected"':'')?>>1:50,000</option>
              <option value="25000"<?php echo($thePositionData['scale']==25000?' selected="selected"':'')?>>1:25,000</option>
              <option value="10000"<?php echo($thePositionData['scale']==10000?' selected="selected"':'')?>>1:10,000</option>
              <option value="5000"<?php echo($thePositionData['scale']==5000?' selected="selected"':'')?>>1:5,000</option>
            </select>
          </td>
          <td><input type="button" value="Delete" onclick="delete_positon('<?php echo $thePosition; ?>')" style="border:3px double #600;background-color:#c00;color:#fff;font-weight: bold;" /></td>
<?php
$sLinks = '';
if (get_option('ioz_gp_show_google_maps')) {
  $sLinks .= ioz_gp_get_google_maps_link($thePosition).'&nbsp;';
}
if (get_option('ioz_gp_show_google_earth')) {
  $sLinks .= ioz_gp_get_google_earth_link($thePosition).'&nbsp;';
}
if (get_option('ioz_gp_show_multimap')) {
  $sLinks .= ioz_gp_get_multimap_link($thePosition).'&nbsp;';
}
if (get_option('ioz_gp_show_msn_ve')) {
  $sLinks .= ioz_gp_get_msn_ve_link($thePosition).'&nbsp;';
}
?>
          <td><?php echo $sLinks; ?></td>
        </tr>
        <?php } ?>
      </table>
      <p class="submit" style="text-align:left;"><input type="submit" value="Update Positions" style="font-weight: bold;" /></p>
      <p class="small">You can edit multiple fields at the same time and submit the changes :)</p>
    </form>
    <br />
    <form action="<?php echo $location; ?>" method="post">
      <input type="hidden" name="ioz_gp_action" value="add_position" />
      <fieldset class="options">
        <legend>Add position</legend>
        <table>
          <tr>
            <th>ID</th>
            <th>Place Name</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th></th>
            <th>Scale</th>
            <th></th>
          </tr>
          <tr>
            <td><input type="text" size="15" value="" name="ioz_gp_position_id" /></td>
            <td><input type="text" size="20" value="" name="ioz_gp_position_place_name" /></td>
            <td><input type="text" size="12" value="" name="ioz_gp_position_latitude" id="ioz_gp_position_latitude" /></td>
            <td><input type="text" size="12" value="" name="ioz_gp_position_longitude" id="ioz_gp_position_longitude" /></td>
            <td><input type="button" value="&Lambda;" title="Center on Map" onClick="javascript:frames['google_map'].fnDoPan()" /></td>
            <td>
              <select name="ioz_gp_position_scale">
                <option value="40000000">1:40,000,000</option>
                <option value="20000000">1:20,000,000</option>
                <option value="10000000">1:10,000,000</option>
                <option value="4000000">1:4,000,000</option>
                <option value="2000000">1:2,000,000</option>
                <option value="1000000">1:1,000,000</option>
                <option value="500000">1:500,000</option>
                <option value="200000">1:200,000</option>
                <option value="100000" selected="selected">1:100,000</option>
                <option value="50000">1:50,000</option>
                <option value="25000">1:25,000</option>
                <option value="10000">1:10,000</option>
                <option value="5000">1:5,000</option>
              </select>
            </td>
            <td><input type="submit" value="Add Position" style="font-weight: bold;" /></td>
          </tr>
        </table>
        <iframe name="google_map" id="google_map" src="<?php echo get_option('siteurl') ?>/wp-content/plugins/wp-geopositions-map/google-map.html" style="width:740px; height:400px; border:0; margin:0; padding:0;" frameborder="0" scrolling="no"></iframe>
        <p>If the new position already exists the old will be overwritten!</p>
      </fieldset>
    </form>
  </fieldset>
  <br />
  <form name="ioz_gp_form_options" method="post" action="<?php echo $location ?>">
    <input type="hidden" name="ioz_gp_action" value="save_options" />
    <fieldset class="options">
      <legend><input name="ioz_gp_show_google_maps" type="checkbox" id="ioz_gp_show_google_maps" value="ioz_gp_show_google_maps"<?php if($ioz_gp_show_google_maps == true) {?> checked="checked" <?php } ?> /> Show Google Maps Links</legend>
      <table width="100%" cellspacing="2" cellpadding="5" class="editform">
        <tr valign="top">
          <th width="33%" scope="row">Link HTML Code</th>
          <td><input name="ioz_gp_code_google_maps" type="text" id="ioz_gp_code_google_maps" value="<?php echo $ioz_gp_code_google_maps ?>" size="50" />
          <br />HTML code that will be shown in Google Maps Links</td>
        </tr>
      </table>
    </fieldset>
    <fieldset class="options">
      <legend><input name="ioz_gp_show_google_earth" type="checkbox" id="ioz_gp_show_google_earth" value="ioz_gp_show_google_earth" <?php if($ioz_gp_show_google_earth == true) {?> checked="checked" <?php } ?> /> Show Google Earth Links</legend>
      <table width="100%" cellspacing="2" cellpadding="5" class="editform">
        <tr valign="top">
          <th width="33%" scope="row">Link HTML Code</th>
          <td><input name="ioz_gp_code_google_earth" type="text" id="ioz_gp_code_google_earth" value="<?php echo $ioz_gp_code_google_earth ?>" size="50" />
          <br />HTML code that will be shown in Google Earth Links</td>
        </tr>
      </table>
    </fieldset>
    <fieldset class="options">
      <legend><input name="ioz_gp_show_multimap" type="checkbox" id="ioz_gp_show_multimap" value="ioz_gp_show_multimap" <?php if($ioz_gp_show_multimap == true) {?> checked="checked" <?php } ?> /> Show MultiMaps.com Links</legend>
      <table width="100%" cellspacing="2" cellpadding="5" class="editform">
        <tr valign="top">
          <th width="33%" scope="row">Link HTML Code</th>
          <td><input name="ioz_gp_code_multimap" type="text" id="ioz_gp_code_multimap" value="<?php echo $ioz_gp_code_multimap ?>" size="50" />
          <br />HTML code that will be shown in MultiMaps.com Links</td>
        </tr>
      </table>
    </fieldset>
    <fieldset class="options">
      <legend><input name="ioz_gp_show_msn_ve" type="checkbox" id="ioz_gp_show_msn_ve" value="ioz_gp_show_msn_ve" <?php if($ioz_gp_show_msn_ve == true) {?> checked="checked" <?php } ?> /> Show MSN Virtual Earth Links</legend>
      <table width="100%" cellspacing="2" cellpadding="5" class="editform">
        <tr valign="top">
          <th width="33%" scope="row">Link HTML Code</th>
          <td><input name="ioz_gp_code_msn_ve" type="text" id="ioz_gp_code_msn_ve" value="<?php echo $ioz_gp_code_msn_ve ?>" size="50" />
          <br />HTML code that will be shown in MSN Virtual Earth Links</td>
        </tr>
      </table>
    </fieldset>
    <p class="submit">
      <input type="submit" name="Submit" value="Save Options &raquo;" />
    </p>
  </form>
</div>
<?
}
?>