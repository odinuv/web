<?php
require ('../../design/head.php');
head('Aplikační programové vybavení', 'PHP, SQL, HTML, webová aplikace, databázová aplikace, relační databáze', 'Stránka předmětu Aplikační programové vybavení', '', '', 'apv');
?>
<h1 id='apv'>APV <?php blink('cs/apv/#apv'); ?></h1>
<h2 id='terminy'>Termíny <?php blink('cs/apv/#terminy'); ?></h2>
<ul>
	<li>10. 10. &ndash; Schválení zadání (pokud chcete mít vlastní)</li>
	<li>31. 10. &ndash; První odevzdání projektu<!-- &ndash; <a href='hodnoceni.txt' class='track' rel='nofollow'>hodnocení projektů</a>--></li>
	<li>19. 12. &ndash; Začátek zkouškového a čas, kdy byste měli mít projekt hotový</li>
	<li>31. 1. &ndash; Poslední možný termín zkoušky a <strong class='warning'>nejzazší</strong> termín pro druhé odevzdání projektu</li>
</ul>
<p>
Tuto informaci jsem vložil 23. 9. 2016. Kdyby došlo ke změně, tak ji pošlu e-mailem.
</p>
<h2 id='obsah'>Obsah předmětu <?php blink('cs/apv/#obsah'); ?></h2>
<p>
Databázové aplikace a webové aplikace a související technologie. Základy programování webových aplikací a databázových aplikací.
	Lehounký úvod do vývoje aplikací a sítí. Předmět je vypisován v letním i zimním semestru.
	<strong><a href='http://odinuv.cz/en/apv/'>Anglická verze obsahu (beta)</a></strong>
</p>
<h2 id='pozadavky'>Požadavky na předmět <?php blink('cs/apv/#pozadavky'); ?></h2>
<ul>
	<li>Odevzdaný projekt a napsaný test.</li>
	<li>Získání alespoň 90 bodů na <a href='http://codecademy.com' title='Codecademy'>Codecademy</a> &ndash; <strong><a href='codecademy.php'>Ověřit</a></strong>.
	</li>
	<li>Přednášky ani cvičení nejsou povinné.</li>
	<li>Výsledná známka vznikne složením známky z projektu a známky testu.</li>
</ul>
<h2 id='zadani'>Standardní zadání projektu</h2>
<p>
Vytvořte webovou aplikaci pro evidenci přítelkyň, přítelů, adres, vztahů a schůzek. Hlavním prvkem aplikace je evidence
osob a schůzek mezi nimi, tedy jakýsi adresář. U každé osoby se zaznamenává jméno, příjmení, věk, bydliště a kontaktní
údaje. Každá osoba může mít libovolný počet kontaktních údajů (mobil, Jabber, Skype, &hellip;). Každá osoba může mít
vztah s libovolnými jinými osobami v databázi. U každého vztahu se zaznamenává délka trvání a typ (známý, přítel,
přítelkyně, manžel, &hellip;). Dále se také zaznamenávají schůzky mezi jednotlivými osobami. Schůzky se může účastnit
libovolný počet osob. U schůzky se dále zaznamenává datum a místo. Osoba může mít více kontaktů stejného typu (např. dva emaily).
Typy kontaktů jsou definované dynamicky v databázi a uživatel je může měnit. Aplikace musí umožňovat přidání, změnu a odstranění
vložených údajů. Aplikace by měla umožňovat snadné přidávání
a změnu osob a schůzek.
Využijte navržené schéma databáze a vytvořte databázi a implementujte aplikaci.
</p>
<h3 id='schema'>Schéma databáze</h3>

<figure>
	<img src='model.png' alt='Schéma databáze' />
</figure>

<p>
Ve cvičení se bude používat jazyk PHP a databáze PostgreSQL. Můžete ale použít i jiný jazyk pro skriptování na straně
serveru (Perl, &hellip;) i jinou databázi (MySQL, MSSQL, &hellip;). Pokud vám nevyhovuje standardní zadání projektu,
můžete mít vlastní. <strong class='warning'>Musíte se však rozmyslet do 10. 10. 2016</strong>.
</p>
<h3 id='pozadavky-zadani'>Požadavky na vlastní zadání projektu <?php blink('cs/apv/#pozadavky-zadani'); ?></h3>
<p>Pokud chcete mít vlastní zadání projektu, musí splňovat následující požadavky:</p>
<ul>
	<li>Aplikace musí pracovat s databází (alespoň 6 tabulek s vazbami).</li>
	<li>Použití skriptování na straně serveru.</li>
	<li>Aplikace musí být vaše práce.</li>
	<li>Aplikace musí být odevzdána se zdrojovým kódem.</li>
	<li>Projekty s vlastním zadáním musí být odevzdány před zkouškou.</li>
	<li>Vlastní zadání musí být předem schváleno! Jinak se vystavujete riziku, že vám u zkoušky řeknu, že to je pitomost.</li>
</ul>
<p>
Zadání stvoříte nejlépe tak, že se pokusíte nakreslit schéma databáze. Nemusíte si lámat hlavu s tím, jestli to máte dobře nebo ne,
v každém případě se stavte osobně a opravíme to. Pro namodelování struktury doporučuji pro MySQL použít vynikající
<a href='http://dev.mysql.com/downloads/workbench/'>MySQL Workbench</a>, který umožňuje naklikané schéma převést do
obrázku i do struktury databáze a naopak. Pro PostgreSQL je možné použít
    <a href='http://www.sqlpower.ca/page/architect_download_os'>PowerArchitect Community Edition</a>,
exportní soubor se vygeneruje přes funkci &bdquo;Forward engineer&ldquo;.
</p>
<h2 id='informace'>Informace o zkoušce <?php blink('cs/apv/#informace'); ?></h2>
<ul>
	<li>zkouška má písemnou a ústní část</li>
	<li>písemná část:
		<ul>
			<li>Trvá asi 70minut.</li>
			<li>Obsahuje příklady, ve kterých musíte napsat SQL dotazy; SQL dotazy si při zkoušce můžete zkoušet na své databázi. Příklady s SQL dotazy jsou <strong class='warning'>nutné</strong> k úspěšnému ukončení zkoušky. V SQL dotazech je zakázáno používat kartézský součin (protože se vás snažím dokopat k tomu, abyste se naučili pracovat s JOINem).</li>
			<li>Můžete při ní používat libovolné zdroje a pomůcky kromě cizího mozku, tedy můžete používat libovolné knížky, opory, celý internet, ale nesmíte se bavit se sousedem.</li>
			<li>Doporučuji nachystat si tahák.</li>
		</ul>
	</li>
	<li>ústní část:
		<ul>
			<li>Trvá pro jednoho studenta alespoň 20 minut. Na ústní zkoušku tedy bohužel musíte čekat. Pořadí si studenti určí domluvou, já do toho nezasahuji. Pokud si tedy chcete mezi písemnou a ústní částí zkoušky někam odskočit, není to problém.</li>
			<li>Součástí ústní zkoušky je i diskuze k projektu. Je tedy <strong>velmi vhodné</strong>, abyste měli v době zkoušky projekt hotový a funkční.</li>
			<li>Projekt musí být vždy někde v provozu (akela nebo libovolný hosting, nebo notebook, který si donesete). K projektu musíte mít také zdrojový kód (na flashce, v 3. odevzdávárně, na ntb)</li>
		</ul>
	</li>
</ul>
<h3 id='odevzdani'>Jak je to s odevzdáním projektu <?php blink('cs/apv/#odevzdani'); ?></h3>
<p>
Odevzdávání projektu v APV je trochu netradiční v tom, že odevzdáváte 2&times; stejný projekt. Z toho vyplývá, že se i
požadavky na jednotlivá odevzdání liší &ndash; tj. pokud dostanete na první odevzdání A, tak to neznamená, že máte vyhráno.
To znamená, že jste <strong class='warning'>začali</strong> dobře.
</p>
<p>
Poprvé odevzdáváte rozpracovanou aplikaci. Do odevzdávárny tedy dejte to, co máte. Měli byste mít minimálně to, co se do té doby udělá na cvičení,
což je zhruba: 
</p>
<ul>
	<li>založená databáze,</li>
	<li>rozchozený šablonový systém,</li>
	<li>skript, který vypisuje něco z databáze,</li>
	<li>skript, který umí do DB něco vložit.</li>
</ul>
<p>
Kromě toho, byste už měli mít v aplikaci také něco vlastního, zaměřte se především na:
</p>
<ul>
	<li>správa kontaktů, schůzek, vztahů se na cvičení určitě dělat nebude, takže na kterékoliv z těchto částí již můžete začít pracovat,</li>
	<li>jak se bude aplikace celkově ovládat &ndash; můžete si udělat například statické stránky a formuláře, 
	na kterých si ujasníte, jestli víte, <strong>co</strong> máte dělat,</li>
	<li>můžete pracovat na layoutu aplikace &ndash; jaké bude rozložení informací na obrazovce aplikace. (Pokud chcete být profi, tak začněte na <a href='http://getbootstrap.com/'>Bootstrap</a> nebo <a href='http://semantic-ui.com/'>SemanticUI</a>).</li>
</ul>
<p>
Známka z prvního odevzdání samozřejmě není finální, ale hodnotí momentální stav. Asi nejlepší slovní interpretace je: &bdquo;Pokud při prvním odevzdání
dostanete známku XY a budete na projektu pracovat stejným tempem, tak na konci semestru dostanete z projektu taky známku XY,
pokud chcete známku lepší, tak musíte přidat.&ldquo;
</p>
<p>
Druhé odevzdání je konečná verze projektu. Druhé odevzdání je povinné, bez něj nedostanete zapsanou známku. Můžete jít na zkoušku i bez hotového projektu, ale 
budete s ním potom muset přijít znovu (známka z písemné části vám zůstane). Při druhém odevzdání by měl být projekt hotová aplikace.
Za nalezené chyby se nestřílí, ale hlavně by odevzdaný projekt měl <strong class='warning'>vypadat jako aplikace</strong> a měl by obsahovat požadované funkce.
To znamená, že by aplikaci mělo být schopen ovládat i člověk, který ji nevytvořil. Neměla by vypisovat ladící hlášení a měla by vypisovat uživateli srozumitelné chyby. Funkce aplikace by měly být nějakým způsobem kompletní - tzn. např. že pokud půjde osobě přidat kontaktní údaj, měl by u ní někde být vidět, a mělo by být možné ho upravit a smazat.
</p>

<?php
require('../../design/foot.php');
foot('sidebar.php');
