<?php
/*
 * Úvodní stránka webu Linux pro lidi (LINPL)
 * Projekt: LINPL
 * Vytvořil: Janek
 */
?>
<!doctype html>
<html style=" overflow-y: hidden;">

	<head>

		<title>Linux pro lidi</title>
    <meta charset="UTF-8">
    <meta name="description" content="Instalace a podpora linuxu">
    <meta name="keywords" content="PC, Linux, support">
    <meta name="author" content="Jan Slovák">

		<script type="text/javascript" src="../scripts/script.js"></script>
		<script src="https://www.recaptcha.net/recaptcha/api.js" async defer></script>


		<link rel="stylesheet" href="../styles/style.css">


	</head>

  <body>

		<form id="dotaznik">

								<section id="type_of_computer">
									<div class="name">
										<h4>Notebook vs stolní PC</h4>
									</div>
									<div class="hlava">
										<h5></h5>
										<h2>Používáte stolní počítač, nebo notebook?</h2>
										<div class="odpoved">
											<input type="radio" value="pc" name="type_of_computer" class="check_button" id="pc">
											<button type="button" class="obraz" onclick="check('pc', true)">  <img width="100%" src="../icons/pc.svg"> Stolní počítač </button>
											<input type="radio" value="ntb" name="type_of_computer" class="check_button" id="ntb">
											<button type="button" class="obraz" onclick="check('ntb', true)">  <img width="100%" src="../icons/ntb.svg"> Notebook </button>
											<input type="radio" value="placeholder" name="type_of_computer" class="check_button" id="another" checked>
										</div>
									</div>
									<div class="menu">
										<button type="button" class="jump" onclick="jump('type_of_computer');">Přeskočit</button>
										<button type="button" class="next" onclick="next('type_of_computer');">Další otázka</button>
									</div>
								</section>

								<section id="age_of_computer">
									<div class="name">
										<h4>Stáří počítače</h4>
									</div>
									<div class="hlava">
										<h5></h5>
										<h2>Kolik je vašemu počítači přibližně let?</h2>
										<div class="odpoved">
											<input oninput="change('age', this.value)" type="range" name="age_of_computer" min="0" max="16" value="0" class="slider">
											<label for="age" id="age">0 let</label>
										</div>
									</div>
									<div class="menu">
										<button type="button" onclick="jump('age_of_computer');" class="jump">Přeskočit</button>
										<button type="button" class="next" onclick="next('age_of_computer');">Další otázka</button>
									</div>
								</section>

								<section id="how_to_contact">
									<div class="name">
										<h4>Preferovaný způsob kontaktu</h4>
									</div>
									<div class="hlava"  >
										<h5></h5>
										<h2>Jak si přejete být kontaktováni?</h2>
										<div class="odpoved">
											<input type="radio" value="email" name="how_to_contact" class="check_button" id="email">
											<button type="button" class="obraz"  onclick="display('email')">  <img width="100%" src="../icons/email.svg"> Email </button>
											<input type="radio" value="phone" name="how_to_contact" class="check_button" id="phone">
											<button type="button" class="obraz"  onclick="display('phone')" id="two">  <img width="100%" src="../icons/phone.svg"> Telefon  </button>
											<input type="radio" value="placeholder" name="how_to_contact" class="check_button" id="one" checked>
										</div>
									</div>
									<div class="menu">
										<button type="button" onclick="next('contact');" class="next">Další otázka</button>
									</div>
								</section>

								<section id="email1">
									<div class="name">
										<h4>Email:</h4>
									</div>
									<div class="hlava">
										<h5></h5>
										<div class="odpoved">
											<input type="email" onchange="emailChange()" name="email_text" id="emailValue">
										</div>
									</div>
									<div class="menu">
										<button type="button" class="next" onclick="next('adv_info');">Další otázka</button>
									</div>
								</section>

								<section id="phone1">
									<div class="name">
										<h4>Telefon:</h4>
									</div>
									<div class="hlava">
										<h5></h5>
										<div class="odpoved">
											<input type="tel" id="phoneValue" onchange="phoneChange()" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" placeholder="123-456-789" name="phone_text">
										</div>
									</div>
									<div class="menu">
										<button type="button" class="next" onclick="next('adv_info');">Další otázka</button>
									</div>
								</section>

								<section id="time">
									<div class="name">
										<h4>Prefarovaný čas kontaktu</h4>
									</div>
									<div class="hlava">
										<h5></h5>
										<h2>Zadejte prosím čas, ve kterém si přejete být kontaktováni</h2>
										<div class="odpoved">
											<input type="time" id="contact_from" name="contact_from" value="00:00">
											<input type="time" id="contact_till" name="contact_till" value="00:00">
										</div>
									<div class="menu">
										<button type="button" onclick="jump('time');" class="jump">Přeskočit</button>
										<button type="button" class="next" onclick="next('time');">Další otázka</button>
									</div>
								</div>

								</section>
								<section id="adv_info">
									<div class="name">
										<h4>Poznámky a informace</h4>
									</div>
									<div class="hlava">
										<h5></h5>
										<h2>Chci doplnit další informace (může v budoucnu ušetřit čas)</h2>
										<div class="odpoved">
											<input type="text" name="adv_info" id="adv_info_text">
										</div>
									</div>
									<div class="menu">
										<button type="button" class="jump" onclick="jump('adv_info');">Přeskočit</button>
										<button type="button" class="next" onclick="next('adv_info');">Další otázka</button>
									</div>
								</section>

								<section id="souhlasy">
									<div class="name">
										<h4>Souhlasy</h4>
									</div>
									<div class="hlava">
										<h5>Ještě pro vás máme pár věcí, se kterými bychom byli rádi, kdybyste souhlasili</h5>
										<div class="odpoved">
											<h5>souhlasím s obchodními podmínkami a uchováváním informací<input type="checkbox" id="souhlasy_text"></h5>
										</div>
									</div>
									<div class="menu">
										<button type="button" class="jump" onclick="jump('souhlasy');">Přeskočit</button>
										<button type="button" class="next" onclick="next('souhlasy');">Další otázka</button>
									</div>
								</section>

								<section id="captcha">
									<div class="name">
										<h4>Ochrana proti robotům</h4>
									</div>

										<div  class="g-recaptcha" data-sitekey="6LeZutMcAAAAAJ5Ng28WpVwW_dYcJlRax4C-WiCP"></div >

								</section>

								<button type="button" onclick="validation()" name="button" id="validate">Odeslat</button>
								<button type="button" onclick="back()" name="button" id="back_to_changes">Opravit</button>
								<button type="button" name="button" onclick="thanks()" id="submit">Odeslat</button>
	            </form>

							<section id="uploading_info">
								<h3>Děkujeme Vám za vyplnění formuláře, <br> pokud se nám podaří Váš zápis nahrát <br> tak Vás budeme kontaktovat,  <br> abychom domluvili další podrobnosti</h3>
							</section>

							<section id="thanks">
								<h3>Děkujeme za vyplnění formuláře, <br> budeme Vás kontaktovat, <br> abychom domluvili další podrobnosti</h3>
							</section>

	      </div>
	    </body>
      </html>
