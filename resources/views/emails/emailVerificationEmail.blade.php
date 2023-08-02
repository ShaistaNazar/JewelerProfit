<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>

@media only screen and (min-width:320px) and (max-width:1279px) {
  table { width: 100% !important;  }
  .temp_logo img { width: 160px !important;}
}

</style>
</head>
<body style="margin:0px; padding:0px; background:#fff;font-family: 'Poppins', sans-serif;">
<table width="900" border="0"  cellspacing="0" cellpadding="0" align="center" style="background:#fff; overflow: hidden; margin-top: 60px; margin-bottom: 50px; 
border:1px solid #8aa4ee; 
box-shadow: 0px 3px 6px 0px rgba(133, 133, 133, 0.12),inset 0px 0px 1px 0px rgba(255, 187, 0, 0.57);">
  <tbody> 
    <tr> 
      <td width="500" height="110" valign="center" align="center" style=" padding: 20px 20px 20px;  ">
        <span class="temp_logo" style=" padding: 20px 0px 30px; display: block;border-bottom: 1px solid #cecece; max-width: 500px;"><a href="#"> 
        <img src="{{URL::asset('/assets/logo.png')}}" alt="logo" class_to_pass="responsive-logo mx-auto d-block" style="display: block; width: 210px;" /></a></span>
      
      </td> 
    </tr>
    <tr> 
      <td valign="top" height="40"></td> 
    </tr>  


    <tr> 
      <td width="800" valign="top" ><table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tbody>
            <tr>
              <td width="600" height="50">
                <h2 style=" margin: auto; text-align: center; padding: 0px 50px 20px;font-size: 24px; color: #000; display: block;  font-weight: bold; max-width: 500px;">Email Verification</h2>
              </td>  
            </tr>  


            <tr>
              <td width="600" height="">
                <p style=" margin: 0px; margin: auto; text-align: center; padding: 0px 50px 0px;font-size: 18px; line-height: 1.5; color: #606060; display: block; font-family: 'Roboto', sans-serif;  font-weight: 400; max-width: 500px;">If you’ve lost your password or to reset it,
                  Press the Button below to get started. </p>
              </td>  
            </tr> 
          </tbody>
        </table></td> 
    </tr>

    <tr> 
      <td height="40" valign="top"></td> 
    </tr>

    <tr> 
      <td width="800" valign="top" ><table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tbody>
            <tr>
              <td width="600" height="50">
                <p style="padding: 0px 20px;"><a href="{{ route('user.verify', $token) }}" style=" text-align: center; font-weight: 500; border-radius: 50px; background: #3d69e7; display: block; font-size: 18px; padding: 18px 25px; max-width: 260px; margin: auto; color: #fff; text-decoration:none !important;">Verify Email Adress</a></p>
              </td>  
            </tr>  

            <tr> 
              <td height="60" valign="top"></td> 
            </tr> 
          </tbody>
        </table></td> 
    </tr>


    <tr> 
      <td height="150" valign="top"></td> 
    </tr> 

    <tr> 
      <td width="800" valign="top" ><table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tbody>  
            <tr>
              <td width="800" height="" >
                <strong style="font-size: 16px; line-height: 60px; margin: 0px; background: #000; color: #fff; display: block;  font-weight: 400 ; text-align: center;border-top: 1px solid #cecece; ">Copyright  All Rights Reserved </strong>
              </td>  
            </tr> 
          </tbody>
        </table></td> 
    </tr>

  
  </tbody>
</table>
</body>
</html>