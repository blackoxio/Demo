<?php


if(isset($_POST['cal']))
{
  extract($_POST);
  
  //calculate capping of binary pairs
  $capping = floor($capping / $binary);
  //initalize output
  echo "<table border=1>
  <tr>
  <td>Level</td>
  <td>Members</td>
  <td>Members x Binary</td>
  <td>Total Binary</td>
  <td>Qualified Binary per Member</td>
  <td>Total Qualified Binary</td>
  <td>Amount to be paid</td>
  </tr>
  ";
  
  //initialize working vars
  $totalLevels = $levels;
  $sumTotalBinary = 0;
  $sumQualifiedBinary = 0;
  $sumMembers = 0;
  $sumAmount = 0;
  $netProfit = 0;
  for($i=0;$i<=$levels;$i++)
  {
      $memBinary = (pow(2,$totalLevels) - 1);
      $totalBinary = (pow(2,$i) * $memBinary);
      $qualifiedBinary =($memBinary>=$capping ? $capping: $memBinary);
      $totalQualifiedBinary = pow(2,$i) * $qualifiedBinary;
      echo '<tr>
      <td>'.$i.'</td>
      <td>'.pow(2,$i).'</td>
      <td>'.pow(2,$i).' x '.$memBinary.'</td>
      <td>'.$totalBinary.'</td>
      <td>'.$qualifiedBinary.'</td>
      <td>'.$totalQualifiedBinary.'</td>
      <td>Rs. '.$totalQualifiedBinary * $binary.'</td>
      </tr>';
      
      //initalize next step
      $totalLevels--;
      $sumTotalBinary += $totalBinary;
      $sumQualifiedBinary +=$totalQualifiedBinary;
      $sumMembers += pow(2,$i);
      $sumAmount += $totalQualifiedBinary * $binary;
  }  
  
  
  echo '<tr>
  <td><strong>Total:</strong></td>
  <td><strong>'.$sumMembers.'</strong></td>
  <td>&nbsp;</td>
  <td><strong>'.$sumTotalBinary.'</strong></td>
  
  <td>&nbsp;</td>
  <td><strong>'.$sumQualifiedBinary.'</strong></td>
  <td><strong>Rs. '.$sumAmount.'</strong></td>
  </tr>';
  
  echo '<tr>
    <td style="text-align:right" colspan=6>
        <strong>Total Business/Receipts:</strong> 
    </td>
    
    <td>
    Rs. '.$sumMembers * $sale.'
    </td>
  </tr>
  ';
  
  $netProfit += $sumMembers*$sale; //add total receipts to net profit
  
  echo '<tr>
    <td style="text-align:right" colspan=6>
        <strong>Binary Payout:</strong> 
    </td>
    
    <td>
    - Rs. '.$sumAmount.'
    </td>
  </tr>
  ';
  
  $netProfit -= $sumAmount ;//deduct binary payout from netProfit
  
  echo '<tr>
    <td style="text-align:right" colspan=6>
        <strong>Admin Charge:</strong> 
    </td>
    
    <td>
    + Rs. '.round($sumAmount * ($adminCharge / 100 )).'
    </td>
  </tr>
  ';
  
  $netProfit += round($sumAmount * ($adminCharge / 100 )); //add admin charge to netProfit
  
  echo '<tr>
    <td style="text-align:right" colspan=6>
        <strong>Product Cost:</strong> 
    </td>
    
    <td>
    - Rs. '.$sumMembers * $cost.'
    </td>
  </tr>
  ';
  
   $netProfit -= $sumMembers* $cost; //deduct profit cost
   
  echo '<tr>
    <td style="text-align:right" colspan=6>
        <strong>Net Profit:</strong> 
    </td>
    
    <td>
     Rs. '.$netProfit.'
    </td>
  </tr>
  '; 
   
  echo '<tr>
    <td style="text-align:right" colspan=6>
        <strong>Profit per Member:</strong> 
    </td>
    
    <td>
     Rs. '.round($netProfit/$sumMembers).'
    </td>
  </tr>
  '; 
  
  //close output
  echo "</table>";
}
else{
    ?>
    <form action="" method="post">
        Sale Amount per Package: <br /><input type="text" name="sale"><Br />
        Your Cost: <br /><input type="text" name="cost"><br />
        Levels: <br /><input type="text" name="levels"><br />
        Admin Charge (in %): <br /><input type="text" name="adminCharge"/><br />
        Binary Amount:<br /><input type="text" name="binary"/><br />
        Capping: <br /><input type="text" name="capping"><br />
        <input type="submit" name="cal" value="Calculate">
        
    </form>
    <?php
}
