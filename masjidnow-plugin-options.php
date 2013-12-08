<?php

  if($_POST["masjidnow"]["invalidate-cache"] == true)
  {
    for($i =1; $i <= 12; $i++)
    {
      delete_option("masjidnow-cached-api-response-$i");
      delete_option("masjidnow-cached-api-response-$i-timestamp");
    }
  }

?>


<div>
  <h2>MasjidNow Settings</h2>
  Everytime you update your timings, you should clear the cache.
  <form action="options-general.php?page=masjidnow" method="post">
  
    <input name="masjidnow[invalidate-cache]" value="true" type="hidden"/>
    <input name="Submit" type="submit" value="Clear Cache" />
  </form>
</div>
