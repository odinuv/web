---
layout: slides
title: AMP - Úvod
description: 
transition: slide
permalink: /cs/amp/slides/uvod/
---

<section markdown='1'>
## Úvod
Troška idealismu nezaškodí...
</section>

<section markdown='1'>
## Metodiky vývoje SW
- vždy: zadání ⇒ analýza ⇒ návrh ⇒ implementace ⇒ testování ⇒ naszení ⇒ údržba 
- délka trvání jednotlivých kroků?
- celá řada přístupů v organizaci kroků
- metodika by se vždy měla přizpůsobovat konkrétním podmínkám
    - nejedná se o normu a absolutní pravdu
    - soubor vhodných doporučení
</section>

<section markdown='1'>
## Metodiky vývoje SW
- dva základní typy SW (z pohledu vývoje):
    - 'krabicový' - poskytovaný "as is", bez nároku na změnu (krabice × služba)
    - na míru - přizpůsobovaný požadavkům zákazníka (customizace) nebo kompletně na míru
- enterprise vs. startup        
</section>

<section markdown='1'>
## "Klasické" Metodiky
- Kroky:
    - sběr požadavků, **specifikace zadání**
    - analýza požadavků
    - návrh řešení, architektury, výběr technologie
    - vývoj, programování
    - testování
    - nasazení
    - reklamace ... ?
- Klasické != Staré    
</section>

<section markdown='1'>
## "Agilní" Metodiky
- Výchozí předpoklad:
    - Rezignujeme na fázi "specifikace zadání".
    - Zákazník není přesně schopen specifikovat co potřebuje, protože:
        - jeho potřeby se neustále mění,
        - sám neví jakým způsobem řešit svoje problémy.
- Rezignace na zadání = chaos a ☠
- Agilní metodika ≈ Dobře organizovaný chaos
    - Neorganizovaný chaos = ☠
- Přenesení zodpovědnosti × Micromanagement
</section>

<section markdown='1'>
## Hlavní zásady
- Navrhují a **implementují** se pouze aktuálně požadované funkce.
- Nevytváří se něco, co **možná někdy** někdo bude potřebovat.
- Místo křížového výslechu zákazníka se preferuje rychlé vytvoření prototypu.
- Refactoring, refactoring, refactoring, refactoring, ...
    - Vyžaduje *automatizované* testování 
- Všechny požadavky od zákazníka se sbírají a zaznamenávají.
- Vedoucí projektu ve spolupráci se zákazníkem přiděluje požadavkům prioritu.
</section>

<section markdown='1'>
## Hlavní zásady
- Komunikace:
    - intenzivní, 
    - placatá struktura, 
    - časté schůzky, práce ve skupinách, 
    - meeting, briefing, brainstorming, já jsem king ...
</section>

<section markdown='1'>
## Hlavní zásady
- Flexibilita
    - Vývojový tým musí být schopen reagovat na stále měnící se požadavky zákazníka.
    - Vývojový tým musí být schopen flexibilně měnit strukturu/architekturu aplikace.
    - Zákazník musí být schopen přijmout měnící se termín dodání požadovaných funkcí.
    - Vývojový tým musí být schopen dělat to, co chce zákazník a vzdát se toho, co chce vývojový tým.
    - **Vývojáři nesmí být líto „zahodit“ svou práci**.
</section>

<section markdown='1'>
## Flexibilita
- Nejznámější:
    - Extrémní programování
    - SCRUM
    - Kanban
- Další:
    - Test driven development
    - Crystal
    - Adaptive software development
- Z velké části jsou to variace na totéž téma.
</section>

<section markdown='1'>
## Vlastnosti
- AM vedou k rychlejšímu dodání **nejnutnějších** funkcí.
- Celkový čas realizace projektu bývá spíše delší (vzhledem k mnoha změnám).
- Zákazník je ale spokojenější, protože může nejnutnější funkce používat rychleji.
- AM jsou vhodnější pro menší projekty a menší skupiny lidí.
- AM jsou o něco vhodnější pro SW na míru.
</section>

<section markdown='1'>
## Vlastnosti
- Na velmi velké projekty (stovky vývojářů, roky vývoje) jsou naprosto nevhodné.
- Příliš málo organizované a příliš chaotické.
- Na některé projekty nelze použít vůbec -- komplexní systémy, kde nelze vyžadovat zpětnou vazbu od zákazníka (např. jádro OS).
- Vyžadují spolupráci od zákazníka.
- Vyžadují spolupráci zaměstnanců (softskills), aktivní účast na projektu.
</section>

<section markdown='1'>
## Pokračování

Konec idealismu, zpět k realitě
</section>

<section markdown='1'>
## Bastardní Metodiky

- sběr požadavků od zákazníka
- stanovení priorit vedoucím projektu
- analýza požadavků a návrh řešení nejjednoduššího pro vývojáře (snaha vyhnout se refactoringu)
- implementace některých požadavků s nejvyšší prioritou skoro podle požadavků zákazníka
- refactoring kvůli realizaci požadavků s nižší prioritou
- pevný termín předání
- předání zákazníkovi buď lehce otestované hodně po termínu, nebo neotestované skoro v termínu
- reklamace – skoro zaplacení – soud – exekuce - ☠
</section>

<section markdown='1'>
## Bastardní Argumenty
- Dokumentaci uděláme později, protože zdržuje.
- Testy spustíme až nakonec.
- Dokumentaci uděláme až to bude hotové.
- Testy doděláme až to bude hotové, aby se nemusely pořád přepisovat.
- Začneme to implementovat hned, jak přijde zadání od zákazníka.
- Zákazník chce X, ale uděláme Y, protože to je lepší/rychlejší/jednodušší.
- To si nemusím psát, to vím/si pamatuji.
</section>

<section markdown='1'>
## Bastardní Argumenty cont.
- Potřebujeme software X, abychom mohli vývoj organizovat.
- To si uděláme sami (líp, levněji, rychleji).
- Když už se to mění, tak uděláme XY.
- Uděláme to takhle, dořeší se to potom.
</section>

<section markdown='1'>
## AMP
Jak se nesklouznout k bastardním metodikám.
</section>

<section markdown='1'>
## AMP
- teoreticky jsou agilní metodiky jednoduché
    - horší je to s jejich dodržováním
    - je snadné minout princip a sklouznout k formě (5 min)
- zkusíme experimentovat a vyvinout kousek nějakého existujícího SW
    - každý bude dělat něco a dohromady to bude stát za to
- SCRUM metodika
    - cílem je vyzkoušet agilní postupy v praxi
    - jsou velmi užitečné i mimo agilní vývoj
</section>

<section markdown='1'>
## AMP
- Aplikace Task Manager 
    - Task Management – plánování úkolů, sledování dokončenosti, plánování projektu
    - Další drobné funkce – sledování emailů, grafy
    - Brněnská firma IT Park
    - PHP + MySQL
- **Aktivní** účast na projektu.    
- Možnost vykonání povinné praxe
    - Bakalářská – 100 hodin
    - Magisterská – 150 hodin
    - Sledování hodin (nahlásit předem)
</section>

<section markdown='1'>
## AMP
- do čtvrtka (22.9.2016) poslat strukturovaný odborný životopis
    - vynechte osobní údaje
    - čím můžete přispět k řešení projektu
    - jakou funkci můžete/chcete zastávat
        - teamleader
        - vývoj
        - testování
        - překlad/dokumentace
        - ostatní?
    - Zašlete na **ondrej.popelka@mendelu.cz**
</section>

