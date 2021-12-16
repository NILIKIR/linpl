/*
 * souhrný js
 * Projekt: LINPL
 * Vytvořil: Janek
 */
var computerValue = "placeholder";
var computerAge = 25;
var contactMethod;
var emailValid=false;
var phoneValid=false;
var xhttp = new XMLHttpRequest();
var knowledgebase_span;
var form_span;
var width;
var knowledgebase_title;
var to_knowledgebase;
var form;
var to_form;
var pre_form;
var knowledgebase_name;
var knowledgebase_anotation;

function emailChange() {
  let regexEmail = /\S+@\S+\.\S+/;
  if (document.getElementById("emailValue").value.match(regexEmail)) {/* Pokud se jedná o email*/
    emailValid = true;
  } else {
    alert("zadali jste neplatnou emailovou adresu, pokud budete pokračovat s neplatnou emailovou adresou, nebudeme schopni vás kontaktovat");
    emailValid = false;
  }
}

function phoneChange() {
  if (isNaN(document.getElementById("phoneValue").value)) {
    phoneValid = false;
    alert("zadali jste neplatný telefon, pokud budete pokračovat s neplatným telefonem, nebudeme schopni vás kontaktovat");
  } else {
    phoneValid = true;
  }
}


function submit_fun(){

  validation_code = grecaptcha.getResponse();
  if (window.location.hostname === "localhost") {/*Pokud přistupuji ze serveru localhost*/
    xhttp.open("POST", "https://localhost/release/sent/sent.php");
  }else{
    xhttp.open("POST", "https://linux.nggcv.cz/sent/sent.php");
  }
  xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
  xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
  var contact;

  if (contactMethod==="email"){
    contact = document.getElementById("emailValue").value;
  } else
  if (contactMethod==="phone"){
    contact = document.getElementById("phoneValue").value;
    }

    xhttp.send("validation_code="+validation_code+"&contact="+contact+"&type_of_computer="+computerValue+"&age_of_computer="+computerAge+"&time_from="+document.getElementById('contact_from').value+"&time_till="+document.getElementById('contact_till').value+"&adv_info="+document.getElementById('adv_info_text').value);

    xhttp.onload = function(){
      if (xhttp.readyState=4){
        if (xhttp.responseText === "true") {
          document.getElementById("uploading_info").style.display = "none";
          document.getElementById("thanks").style.display = "block";
        }
        else if(xhttp.responseText === "false"){
          document.getElementById("uploading_info").style.display = "none";
          document.getElementById("dotaznik").style.display = "block";
          alert("Vyplňte prosím reCaptchu");
        }else{
          document.getElementById("uploading_info").style.display = "none";
          document.getElementById("dotaznik").style.display = "block";
          alert(xhttp.responseText);
        }
      }
    }
  }


function change(pom1, pom2){
    if (pom2 == 16){
      document.getElementById(pom1).innerHTML  ="15+ let";
    }
    else {
      document.getElementById(pom1).innerHTML= pom2 + " let";
    }
    computerAge = pom2;
  }

function check(pom1, pom2){
    document.getElementById(pom1).checked=true;
    if (pom2){
      computerValue = pom1;
    }
    else{
      contactMethod = pom1
    }
  }

function display(pom){
  if (pom == 'email') {
    document.getElementById('time').style.display = "none";
    document.getElementById('phone1').style.display = "none";
    document.getElementById('email1').style.display = "block";
  }
  else {
    document.getElementById('time').style.display = "block";
    document.getElementById('phone1').style.display = "block";
    document.getElementById('email1').style.display = "none";
  }
  check(pom, false);
  }

  function validation(){
    if (document.getElementById('one').checked) { /*Pokud nebyla zakliknuta žádná možnost kontaktu*/
      alert("Zadejte prosím preferovaný způsob kontaktu");
    }else if ((document.getElementById('emailValue').value == ""&&document.getElementById('email').checked)
    ||(document.getElementById('phoneValue').value == ""&&document.getElementById('phone').checked)) { /*Pokud nejsou vyplněny kontaktní informace*/
      alert("Zadejte prosím své kontaktní informace");
    }else if(emailValid===false&&document.getElementById('email').checked){
      alert("Nebyla zadána platná emailová adresa");
    }else if(phoneValid===false&&document.getElementById('phone').checked){
      alert("Nebylo zadáno platné české telefonní číslo");
    }else{
      var parent = document.getElementById('type_of_computer');
      parent.getElementsByTagName('h2')[0].style.display = "none";
      parent.getElementsByClassName('odpoved')[0].style.display = "none";
      var pom = parent.getElementsByTagName('h5')[0];
      pom.style.display = "block";
      switch (computerValue) {
        case "pc":
          pom.innerHTML= "Vybrali jste, že doma máte stolní počítač";
          break;
        case "ntb":
          pom.innerHTML= "Vybrali jste, že doma máte notebook";
          break;
          default:
          pom.innerHTML= "Neybrali jste, co za typ počítače doma máte";
          break;
          }

      parent = document.getElementById('age_of_computer');
      parent.getElementsByTagName('h2')[0].style.display = "none";
      parent.getElementsByClassName('odpoved')[0].style.display = "none";
      pom = parent.getElementsByTagName('h5')[0];
      pom.style.display = "block";
      if (computerAge === 25){
        pom.innerHTML= "Nezadali jste věk svého počítače";
      }
      else {
        if (computerAge == 16){
          var pom1  ="15+ let";
        }
        else {
          var pom1 = computerAge + " let";
        }
        pom.innerHTML= "Zadali jste, že vašemu počítači je " + pom1;
      }

      parent = document.getElementById('how_to_contact');
      parent.getElementsByTagName('h2')[0].style.display = "none";
      parent.getElementsByClassName('odpoved')[0].style.display = "none";
      pom = parent.getElementsByTagName('h5')[0];
      pom.style.display = "block";
      switch (contactMethod) {
        case "email":
          pom.innerHTML= "Zvolili jste, že chcete být kontaktováni mailem";

          parent = document.getElementById('email1');
          parent.getElementsByClassName('odpoved')[0].style.display = "none";
          pom = parent.getElementsByTagName('h5')[0];
          pom.style.display = "block";
          pom.innerHTML ="Váš email je: "+ document.getElementById('emailValue').value;
          break;
        case "phone":
          pom.innerHTML ="Zvolili jste, že chcete být kontaktováni telefonem";


          parent = document.getElementById('phone1');
          parent.getElementsByClassName('odpoved')[0].style.display = "none";
          pom = parent.getElementsByTagName('h5')[0];
          pom.style.display = "block";
          pom.innerHTML ="Vaše telefoní číslo je: "+ document.getElementById('phoneValue').value;


          parent = document.getElementById('time');
          parent.getElementsByTagName('h2')[0].style.display = "none";
          parent.getElementsByClassName('odpoved')[0].style.display = "none";
          pom = parent.getElementsByTagName('h5')[0];
          pom.innerHTML ="Zadali jste, že chcete být kontaktován mezi "+ document.getElementById('contact_from').value +" a "+document.getElementById('contact_till').value;
          pom.style.display = "block";
          break;
        default:
          pom.innerHTML = "Chyba, do této možnosti by se člověk neměl dostat, nezvolili jste, jak si přejete být kontaktováni"
      }

      parent = document.getElementById('adv_info');
      parent.getElementsByTagName('h2')[0].style.display = "none";
      parent.getElementsByClassName('odpoved')[0].style.display = "none";
      pom = parent.getElementsByTagName('h5')[0];
      pom.innerHTML = document.getElementById('adv_info_text').value;
      pom.style.display = "block";

      parent = document.getElementById('souhlasy');
      parent.style.display = "block"
      parent.getElementsByTagName('h5')[0].style.display = "block";
      parent.getElementsByTagName('h5')[1].style.display = "block";
      parent.getElementsByClassName('odpoved')[0].style.display = "block";


      parent = document.getElementById('captcha');
      parent.style.display = "block"

      document.getElementById('validate').style.display="none";
      document.getElementById('back_to_changes').style.display="inline";
      document.getElementById('submit').style.display="inline";}
    }

  function back(){
      var parent = document.getElementById('type_of_computer');
      parent.getElementsByTagName('h2')[0].style.display = "block";
      parent.getElementsByClassName('odpoved')[0].style.display = "block";
      var pom = parent.getElementsByTagName('h5')[0];
      pom.style.display = "none";


      parent = document.getElementById('age_of_computer');
      parent.getElementsByTagName('h2')[0].style.display = "block";
      parent.getElementsByClassName('odpoved')[0].style.display = "block";
      pom = parent.getElementsByTagName('h5')[0];
      pom.style.display = "none";


      parent = document.getElementById('how_to_contact');
      parent.getElementsByTagName('h2')[0].style.display = "block";
      parent.getElementsByClassName('odpoved')[0].style.display = "block";
      pom = parent.getElementsByTagName('h5')[0];
      pom.style.display = "none";

      parent = document.getElementById('email1');
      parent.getElementsByClassName('odpoved')[0].style.display = "block";
      pom = parent.getElementsByTagName('h5')[0];
      pom.style.display = "none";
      pom.innerHTML ="Váš email je: "+ document.getElementById('emailValue').value;


      parent = document.getElementById('phone1');
      parent.getElementsByClassName('odpoved')[0].style.display = "block";
      pom = parent.getElementsByTagName('h5')[0];
      pom.style.display = "none";


      parent = document.getElementById('time');
      parent.getElementsByTagName('h2')[0].style.display = "block";
      parent.getElementsByClassName('odpoved')[0].style.display = "block";
      pom = parent.getElementsByTagName('h5')[0];


      parent = document.getElementById('adv_info');
      parent.getElementsByTagName('h2')[0].style.display = "block";
      parent.getElementsByClassName('odpoved')[0].style.display = "block";
      pom = parent.getElementsByTagName('h5')[0];


      parent = document.getElementById('souhlasy');
      parent.style.display = "none"
      parent.getElementsByTagName('h5')[0].style.display = "block";
      parent.getElementsByTagName('h5')[1].style.display = "block";
      parent.getElementsByClassName('odpoved')[0].style.display = "block";


      parent = document.getElementById('captcha');
      parent.style.display = "none"

      document.getElementById('validate').style.display="inline";
      document.getElementById('back_to_changes').style.display="none";
      document.getElementById('submit').style.display="none";
  }

  function thanks() {
    if (!document.getElementById("souhlasy_text").checked){
      alert("Nesouhlasili jste s obchodními podmínkami a GDPR");
    }else if(!document.getElementById("")){
      pre_submit_fun();
      submit_fun();
    }
  }

  function pre_submit_fun() {
    document.getElementById("dotaznik").style.display = "none";
    document.getElementById("uploading_info").style.display = "block";
  }

  window.onload = function onload(){
    knowledgebase_span = document.getElementById('knowledgebase_span');
    form_span = document.getElementById('form_span');
    knowledgebase_title = document.getElementById('knowledgebase_title');
    to_knowledgebase = document.getElementById('to_knowledgebase');
    to_form = document.getElementById('to_form');
    pre_form = document.getElementById('pre_form');
    knowledgebase_name = document.getElementById('knowledgebase_name');
    knowledgebase_anotation = document.getElementById('knowledgebase_anotation');
    admin_text = document.getElementById('administration');

    onresize();
  }

  window.onresize = function onresize(){
    width = document.body.clientWidth;
    var pom = (width-944)/2;
    knowledgebase_span.style.left = pom + "px";
    form_span.style.left = pom + "px";
  }

  function displayFce() {
    admin_text.style.display = "none";
    form_span.style.padding = "0";
    form_span.style.width = "auto";
    form_span.style.border ="none";
    form_span.innerHTML = "<iframe id='form' src='form/form.php'></iframe>	<button type='button' id='to_form' onclick='to_form_span();'><h1> Zpět k formuláři </h1></button>";

    to_form = document.getElementById('to_form');
    to_form.style.display = "none";

    form_span.style.marginLeft = "160px";
    form = document.getElementById('form');
    pre_form.style.display = "none";

    knowledgebase_span.style.width = "108px";
    knowledgebase_span.style.marginRight="800px";
    knowledgebase_span.style.position = "fixed";
    form_span.style.position = "absolute";

    knowledgebase_title.style.display="none";
    to_knowledgebase.style.display="block";
    to_knowledgebase.innerHTML = "<h1>S čím jsme se již potkali? </h1>"


    knowledgebase_name.style.display = "none";
    knowledgebase_anotation.style.display = "none";

    to_knowledgebase.getElementsByTagName('h1')[0].style.writingMode = "vertical-lr";
  }

  function to_knowledge() {
    if (form != null) {
      form.style.display = "none";
    }
    admin_text.style.display = "block";
    pre_form.style.display = "none";
    to_form.style.display = "block";

    knowledgebase_span.style.width = "758px";
    knowledgebase_span.style.marginRight="150px";
    knowledgebase_name.style.display = "none";

    form_span.style.width = "108px";
    form_span.style.marginLeft="810px";
    form_span.style.padding = "20px";
    form_span.style.border ="1px solid black";
    to_knowledgebase.style.display = "none";
    knowledgebase_title.style.display = "block";
    knowledgebase_span.style.position = "absolute";
    form_span.style.position = "fixed";
    knowledgebase_anotation.style.display = "block";
  }

  function to_form_span(){
    admin_text.style.display = "none";
    form_span.style.padding = "0";
    form_span.style.width = "auto";
    form_span.style.border ="none";
    form_span.style.marginLeft = "160px";
    to_form.style.display="none";
    knowledgebase_span.style.width = "108px";
    knowledgebase_span.style.marginRight="800px";
    knowledgebase_name.style.display = "none";
    knowledgebase_title.style.display = "none";
    to_knowledgebase.style.display = "block";
    form.style.display = "block";
    knowledgebase_span.style.position = "fixed";
    form_span.style.position = "absolute";
    knowledgebase_anotation.style.display = "none";
  }
