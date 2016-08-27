--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

--
-- Name: contact_id_contact_seq; Type: SEQUENCE SET; Schema: public; Owner: xpopelka
--

SELECT pg_catalog.setval('contact_id_contact_seq', 111, true);


--
-- Name: contact_type_id_contact_type_seq; Type: SEQUENCE SET; Schema: public; Owner: xpopelka
--

SELECT pg_catalog.setval('contact_type_id_contact_type_seq', 7, true);


--
-- Name: location_id_location_seq; Type: SEQUENCE SET; Schema: public; Owner: xpopelka
--

SELECT pg_catalog.setval('location_id_location_seq', 51, true);


--
-- Name: meeting_id_meeting_seq; Type: SEQUENCE SET; Schema: public; Owner: xpopelka
--

SELECT pg_catalog.setval('meeting_id_meeting_seq', 19, true);


--
-- Name: person_id_person_seq; Type: SEQUENCE SET; Schema: public; Owner: xpopelka
--

SELECT pg_catalog.setval('person_id_person_seq', 49, true);


--
-- Name: relation_id_relation_seq; Type: SEQUENCE SET; Schema: public; Owner: xpopelka
--

SELECT pg_catalog.setval('relation_id_relation_seq', 91, true);


--
-- Name: relation_type_id_relation_type_seq; Type: SEQUENCE SET; Schema: public; Owner: xpopelka
--

SELECT pg_catalog.setval('relation_type_id_relation_type_seq', 9, true);


--
-- Data for Name: contact_type; Type: TABLE DATA; Schema: public; Owner: xpopelka
--

INSERT INTO contact_type VALUES (2, 'skype', '');
INSERT INTO contact_type VALUES (5, 'jabber', '');
INSERT INTO contact_type VALUES (6, 'web', '');
INSERT INTO contact_type VALUES (1, 'facebook', '');
INSERT INTO contact_type VALUES (4, 'email', '');
INSERT INTO contact_type VALUES (3, 'tel', '\+?([0-9]{3})?\s*[0-9]{3}\s*[0-9]{3}\s*[0-9]{3}');


--
-- Data for Name: contact; Type: TABLE DATA; Schema: public; Owner: xpopelka
--

INSERT INTO contact VALUES (100, 24, 1, 'petal.leonora');
INSERT INTO contact VALUES (101, 28, 1, 'summers.gilda');
INSERT INTO contact VALUES (102, 29, 1, 'remona.deen.3');
INSERT INTO contact VALUES (103, 30, 1, 'lisette.igneess');
INSERT INTO contact VALUES (104, 32, 1, 'marcel.miranda.5');
INSERT INTO contact VALUES (105, 33, 1, 'dion.leclaire.4');
INSERT INTO contact VALUES (106, 34, 1, 'ericka.kreiner.1');
INSERT INTO contact VALUES (35, 8, 3, '724548217');
INSERT INTO contact VALUES (36, 9, 3, '725852711');
INSERT INTO contact VALUES (37, 10, 3, '773525542');
INSERT INTO contact VALUES (38, 11, 3, '776828485');
INSERT INTO contact VALUES (39, 12, 3, '723258369');
INSERT INTO contact VALUES (40, 13, 3, '774123475');
INSERT INTO contact VALUES (41, 14, 3, '735252756');
INSERT INTO contact VALUES (42, 15, 3, '728424666');
INSERT INTO contact VALUES (43, 16, 3, '726587663');
INSERT INTO contact VALUES (44, 17, 3, '726548723');
INSERT INTO contact VALUES (45, 18, 3, '724963797');
INSERT INTO contact VALUES (46, 19, 3, '774564320');
INSERT INTO contact VALUES (47, 20, 3, '775545965');
INSERT INTO contact VALUES (48, 21, 3, '772264852');
INSERT INTO contact VALUES (49, 22, 3, '721253542');
INSERT INTO contact VALUES (50, 23, 3, '722654752');
INSERT INTO contact VALUES (51, 24, 3, '731765214');
INSERT INTO contact VALUES (52, 25, 3, '774251714');
INSERT INTO contact VALUES (53, 26, 3, '774954246');
INSERT INTO contact VALUES (54, 27, 3, '732725825');
INSERT INTO contact VALUES (55, 28, 3, '734821462');
INSERT INTO contact VALUES (56, 29, 3, '732654654');
INSERT INTO contact VALUES (57, 30, 3, '775828254');
INSERT INTO contact VALUES (58, 31, 3, '774741524');
INSERT INTO contact VALUES (59, 32, 3, '775595419');
INSERT INTO contact VALUES (60, 33, 3, '723654179');
INSERT INTO contact VALUES (61, 34, 3, '776853578');
INSERT INTO contact VALUES (1, 1, 4, 'ethyl.herren@gmail.com');
INSERT INTO contact VALUES (2, 2, 4, 'temple.gumbs@outlook.com');
INSERT INTO contact VALUES (3, 3, 4, 'tuan.brauer@gmail.com');
INSERT INTO contact VALUES (4, 4, 4, 'everett.hilbert@live.com');
INSERT INTO contact VALUES (5, 5, 4, 'karl.oshiro@gmail.com');
INSERT INTO contact VALUES (6, 6, 4, 'glennie.hottinger@gmail.com');
INSERT INTO contact VALUES (7, 7, 4, 'maddierankins@gmail.com');
INSERT INTO contact VALUES (8, 8, 4, 'toledo.earlie@gmail.com');
INSERT INTO contact VALUES (9, 9, 4, 'crandall@outlook.com');
INSERT INTO contact VALUES (10, 10, 4, 'colangelo@live.com');
INSERT INTO contact VALUES (11, 11, 4, 'barrientos@yahoo.com');
INSERT INTO contact VALUES (12, 12, 4, 'edmann@hotmail.com');
INSERT INTO contact VALUES (13, 13, 4, 'callender.jessica@gmail.com');
INSERT INTO contact VALUES (14, 14, 4, 'rolando.lung@gmail.com');
INSERT INTO contact VALUES (15, 15, 4, 'tommygun@yahoo.com');
INSERT INTO contact VALUES (16, 16, 4, 'fucha@gmail.com');
INSERT INTO contact VALUES (17, 17, 4, 'oshiro.karl@outlook.com');
INSERT INTO contact VALUES (18, 18, 4, 'maglione.twyla@live.com');
INSERT INTO contact VALUES (19, 19, 4, 'woodford@hotmail.com');
INSERT INTO contact VALUES (20, 20, 4, 'mckay.bess@gmail.com');
INSERT INTO contact VALUES (21, 21, 4, 'lona@gmail.com');
INSERT INTO contact VALUES (22, 22, 4, 'axeman5@gmail.com');
INSERT INTO contact VALUES (23, 23, 4, 'clockMaster1@gmail.com');
INSERT INTO contact VALUES (24, 24, 4, 'petal.nisbet@yahoo.com');
INSERT INTO contact VALUES (25, 25, 4, 'knowsy@gmail.com');
INSERT INTO contact VALUES (26, 26, 4, 'spacey.nisbet@outlook.com');
INSERT INTO contact VALUES (27, 27, 4, 'slonaker@yahoo.com');
INSERT INTO contact VALUES (28, 28, 4, 'summers54@gmail.com');
INSERT INTO contact VALUES (29, 29, 4, 'hilary.deen@gmail.com');
INSERT INTO contact VALUES (30, 30, 4, 'siqueiros@hotmail.com');
INSERT INTO contact VALUES (31, 31, 4, 'householder@gmail.com');
INSERT INTO contact VALUES (32, 32, 4, 'leclaire@outlook.com');
INSERT INTO contact VALUES (33, 33, 4, 'gene.dion@gmail.com');
INSERT INTO contact VALUES (34, 34, 4, 'kiiny.ericka.kreiner@gmail.com');
INSERT INTO contact VALUES (62, 1, 2, 'ethy12');
INSERT INTO contact VALUES (63, 2, 2, 'temple.gumbs');
INSERT INTO contact VALUES (64, 3, 2, 'hilbert3');
INSERT INTO contact VALUES (65, 4, 2, 'everett');
INSERT INTO contact VALUES (66, 5, 2, 'teague');
INSERT INTO contact VALUES (67, 6, 2, 'kaneshiro');
INSERT INTO contact VALUES (68, 7, 2, 'maddie.rankins');
INSERT INTO contact VALUES (69, 8, 2, 'toledo3');
INSERT INTO contact VALUES (70, 9, 2, 'bigbill');
INSERT INTO contact VALUES (71, 10, 2, 'roderick');
INSERT INTO contact VALUES (72, 21, 2, 'lona.sonny');
INSERT INTO contact VALUES (73, 22, 2, 'tristan.axeman');
INSERT INTO contact VALUES (74, 23, 2, 'clock-master');
INSERT INTO contact VALUES (75, 24, 2, 'nisbet.petal');
INSERT INTO contact VALUES (76, 25, 2, 'knowsy');
INSERT INTO contact VALUES (77, 26, 2, 'spacey52');
INSERT INTO contact VALUES (78, 27, 2, 'emiii4x4');
INSERT INTO contact VALUES (79, 28, 2, 'gilda.summer');
INSERT INTO contact VALUES (80, 29, 2, 'hilary.4');
INSERT INTO contact VALUES (81, 30, 2, 'igneess');
INSERT INTO contact VALUES (82, 31, 2, 'householder.alisha');
INSERT INTO contact VALUES (83, 32, 2, 'marcel.miranda');
INSERT INTO contact VALUES (84, 33, 2, 'gene.dion');
INSERT INTO contact VALUES (85, 34, 2, 'kreiner');
INSERT INTO contact VALUES (108, 47, 4, 'frfr@gmail.com');
INSERT INTO contact VALUES (109, 47, 4, 'francis.francoise@gmail.com');
INSERT INTO contact VALUES (110, 47, 4, 'francoise.wood@gmail.com');
INSERT INTO contact VALUES (86, 8, 1, 'earlie.toledo.1');
INSERT INTO contact VALUES (87, 9, 1, 'bill.crandall.3');
INSERT INTO contact VALUES (88, 10, 1, 'roderick.colangelo.1');
INSERT INTO contact VALUES (89, 11, 1, 'alycia.barrientos');
INSERT INTO contact VALUES (90, 12, 1, 'julissa.erdmann');
INSERT INTO contact VALUES (91, 13, 1, 'jesica.callender.3');
INSERT INTO contact VALUES (92, 14, 1, 'rolando.lung.4');
INSERT INTO contact VALUES (93, 15, 1, 'thomas.dowdle.1');
INSERT INTO contact VALUES (94, 16, 1, 'fuchs.tuan');
INSERT INTO contact VALUES (95, 17, 1, 'karl.oshi.1');
INSERT INTO contact VALUES (96, 20, 1, 'bess.mckay');
INSERT INTO contact VALUES (97, 21, 1, 'sonny.sonny');
INSERT INTO contact VALUES (98, 22, 1, 'tristan.axeman');
INSERT INTO contact VALUES (99, 23, 1, 'clockmaster.wingert');


--
-- Data for Name: location; Type: TABLE DATA; Schema: public; Owner: xpopelka
--

INSERT INTO location VALUES (49, 'Hradec Králové', 'Velké náměstí', 26, '500 03', NULL, 'Kavárna U Knihomola', 50.2096232, 15.836109);
INSERT INTO location VALUES (37, 'Llanbedr Dyffryn Clwyd', 'Troed Y Fenlli', 3, 'LL15 1BQ', 'United Kingdom', NULL, 53.1258941, -3.2826918);
INSERT INTO location VALUES (25, 'Hradec Králové', 'Govorova', 628, '500 06', NULL, NULL, NULL, NULL);
INSERT INTO location VALUES (23, 'Hradec Králové', 'Nový Hradec', 754, '500 06', NULL, NULL, NULL, NULL);
INSERT INTO location VALUES (12, 'Budišov nad Budišovkou', 'Halaškovo náměstí', 178, '747 87', NULL, NULL, 49.7943254, 17.6264516);
INSERT INTO location VALUES (26, 'Hradec Králové', 'Rokycanova', 159, '500 06', NULL, NULL, NULL, NULL);
INSERT INTO location VALUES (21, 'Portishead', 'Rodmoor Rd', NULL, 'BS20 7HZ', 'United Kingdom', 'Portishead Bowling Club', 51.4850746, -2.7710376);
INSERT INTO location VALUES (42, 'Brno', 'Kotlářská', 10, '602 00', NULL, 'Rybářské potřeby U Sumce', 49.2060867, 16.599632);
INSERT INTO location VALUES (38, 'Düsseldorf', 'Elisabethstraße', 40, '40 217', 'Germany', NULL, 51.2148005, 6.7745159);
INSERT INTO location VALUES (27, 'Llanfairpwllgwyngyll', 'Ffordd Penmynydd', 5, 'LL61 6UX', 'United Kingdom', NULL, 53.2236409, -4.2026051);
INSERT INTO location VALUES (14, 'Samopše - Mrchojedy', NULL, 4, '285 06', NULL, 'Auto Body Shop', 49.8630894, 14.9288152);
INSERT INTO location VALUES (28, 'Lanškroun', 'Pražské předměstí', 154, '563 01', NULL, NULL, NULL, NULL);
INSERT INTO location VALUES (30, 'Luton', 'University Square', NULL, 'LU1 3JU', 'United Kingdom', 'University of Bedfordshire, Luton Campus', 51.9222583, -0.5311648);
INSERT INTO location VALUES (41, 'Brno', 'Zemědělská', 1, '613 00', NULL, 'school', 49.2100627, 16.6168339);
INSERT INTO location VALUES (43, NULL, NULL, NULL, NULL, NULL, 'Home', NULL, NULL);
INSERT INTO location VALUES (4, 'Bridge of Allan', 'Henderson St', 15, 'FK9 4HN', 'United Kingdom', 'The Allanwater Cafe', 56.1527769, -3.9491236);
INSERT INTO location VALUES (29, 'Lanškroun', 'Zámecká', 419, '563 01', NULL, NULL, NULL, NULL);
INSERT INTO location VALUES (31, 'Pardubice', 'Mahonova', 1530, '532 01', NULL, NULL, NULL, NULL);
INSERT INTO location VALUES (22, 'Sharpness', 'The Docks', NULL, 'GL13 9UN', 'United Kingdom', 'Sharpness Dockers Club', NULL, NULL);
INSERT INTO location VALUES (32, 'Pardubice', 'Přemyslova', 1284, '532 01', NULL, NULL, NULL, NULL);
INSERT INTO location VALUES (44, 'Brno', 'Vodova', 336, '612 00', NULL, 'Hala Vodova', 49.2273177, 16.5827707);
INSERT INTO location VALUES (2, 'Castletown-Bearhaven', 'The Square', NULL, NULL, 'Ireland', 'Ring of Beara', 51.6507621, -9.9103394);
INSERT INTO location VALUES (18, 'Meziměstí', 'Školní', NULL, '549 81', NULL, NULL, 50.6257013, 16.2414235);
INSERT INTO location VALUES (13, 'Nowa Wieś Wrocławska', 'Ulica Nowa', 9, '55-080', 'Poland', NULL, 51.0440184, 16.9163198);
INSERT INTO location VALUES (33, 'Pardubice', 'Albertova', 485, ' ', NULL, NULL, NULL, NULL);
INSERT INTO location VALUES (45, 'Brno', 'Gorkého', 96, '602 00', NULL, 'U Bláhovky', 49.1991243, 16.5913443);
INSERT INTO location VALUES (46, 'Brno', NULL, NULL, NULL, NULL, 'under the clock', NULL, NULL);
INSERT INTO location VALUES (34, 'Bremen', 'Katrepeler Straße', 48, '282 15', 'Germany', NULL, 53.0927528, 8.8061181);
INSERT INTO location VALUES (47, 'Brno', NULL, NULL, NULL, NULL, 'in the park', NULL, NULL);
INSERT INTO location VALUES (36, 'Prachatice', 'Pražská', 103, '383 01', NULL, NULL, NULL, NULL);
INSERT INTO location VALUES (24, 'Bolton', 'Davenport Street', 12, 'BL1 2LT', 'United Kingdom', NULL, 53.5834001, -2.4346145);
INSERT INTO location VALUES (48, 'Praha', 'Aviatická', 2, '161 00', NULL, 'Terminal 1', 50.1068145, 14.2680641);
INSERT INTO location VALUES (6, 'Muir of Ord', 'Old Rd', 182, 'IV6 7UJ', 'United Kingdom', 'Glen Ord Distillery', 57.457622, -4.3236818);
INSERT INTO location VALUES (40, 'Albrechtice nad Orlicí', 'T. G. Masaryka', 128, '517 22', NULL, NULL, NULL, NULL);
INSERT INTO location VALUES (3, 'Stirling', 'Fountain Rd', 27, 'FK9 4AT', 'United Kingdom', NULL, 56.1527769, -3.9491343);
INSERT INTO location VALUES (5, 'Vsetín', 'Sedličky', 6, '755 01', NULL, NULL, NULL, NULL);
INSERT INTO location VALUES (1, 'Holice', 'Nad Splavem', 315, '534 01', NULL, NULL, NULL, NULL);
INSERT INTO location VALUES (15, 'Přišimasy', NULL, 119, '282 01', NULL, NULL, 50.0523956, 14.7588785);
INSERT INTO location VALUES (11, 'Inverness', 'Dochfour Drive', 4, 'IV3 5EF', 'United Kingdom', NULL, 57.4770758, -4.2416873);
INSERT INTO location VALUES (9, 'Linz', 'Mozartstraße', 33, '4020', 'Austria', NULL, 48.3021472, 14.2928913);
INSERT INTO location VALUES (8, 'Bremen', 'Doventorsteinweg', 48, '281 95', 'Germany', 'Agentur Für Arbeit', 53.0855307, 8.8007405);
INSERT INTO location VALUES (19, 'Hradec Králové', 'Rokitanského', 62, '500 03', NULL, 'Univerzita Hradec Králové', 50.2098593, 15.8267625);
INSERT INTO location VALUES (20, 'Plzeň', 'Kollárova ', 6, '301 00 ', NULL, NULL, 49.7478082, 13.3685989);
INSERT INTO location VALUES (39, 'Antwerpen', 'Jan van Rijswijcklaan', 191, '2020', 'Belgium', 'Antwerp Expo', 51.1891488, 4.397781);
INSERT INTO location VALUES (7, 'Linz', 'Promenade', 39, '4010', 'Austria', 'Landestheater Linz', 48.2992233, 14.2838151);
INSERT INTO location VALUES (35, 'Maastricht', 'Fort Willemweg', 47, '6219 PA', 'Netherlands', NULL, 50.8587113, 5.6791561);
INSERT INTO location VALUES (17, 'Bad Zell', 'Linzer Straße', 19, '4283', 'Austria', NULL, 48.3464326, 14.6626733);
INSERT INTO location VALUES (10, 'Holice', 'Husova', NULL, '534 01', NULL, NULL, NULL, NULL);
INSERT INTO location VALUES (16, 'Znojmo', 'Kuchařovická', 1, '669 02', NULL, NULL, 48.8599039, 16.0549261);
INSERT INTO location VALUES (51, 'Paris', 'Avenue Gustave Eiffel', NULL, NULL, NULL, 'La Tour Eiffel', NULL, NULL);


--
-- Data for Name: meeting; Type: TABLE DATA; Schema: public; Owner: xpopelka
--

INSERT INTO meeting VALUES (2, '2016-09-17 11:30:00+02', '', NULL, 42);
INSERT INTO meeting VALUES (3, '2016-09-06 09:30:00+02', 'electrician', '01:30:00', 43);
INSERT INTO meeting VALUES (11, '2016-10-26 18:00:00+02', 'window cleaners', NULL, 43);
INSERT INTO meeting VALUES (15, '2016-09-24 12:30:00+02', 'lunch', NULL, 43);
INSERT INTO meeting VALUES (18, '2016-08-22 19:00:00+02', '', '02:30:00', 44);
INSERT INTO meeting VALUES (4, '2016-08-31 12:00:00+02', '', NULL, 45);
INSERT INTO meeting VALUES (14, '2016-12-07 17:00:00+01', '', NULL, 45);
INSERT INTO meeting VALUES (7, '2016-10-18 09:30:00+02', 'fishing eqp', NULL, 31);
INSERT INTO meeting VALUES (13, '2016-12-05 09:30:00+01', 'fishing eqp', NULL, 12);
INSERT INTO meeting VALUES (5, '2016-09-15 19:30:00+02', 'flowers!', NULL, 46);
INSERT INTO meeting VALUES (10, '2016-09-24 16:30:00+02', '', NULL, 47);
INSERT INTO meeting VALUES (12, '2016-08-18 13:30:00+02', '', '00:30:00', 47);
INSERT INTO meeting VALUES (16, '2016-12-05 20:30:00+01', '', NULL, 47);
INSERT INTO meeting VALUES (17, '2016-09-06 15:00:00+02', 'pickup', NULL, 48);
INSERT INTO meeting VALUES (8, '2016-09-21 13:30:00+02', 'lunch', '02:00:00', 49);
INSERT INTO meeting VALUES (6, '2016-09-17 11:30:00+02', '', NULL, 28);
INSERT INTO meeting VALUES (9, '2016-12-05 14:00:00+01', '', NULL, 41);
INSERT INTO meeting VALUES (1, '2016-12-25 15:00:00+01', 'books', NULL, 41);


--
-- Data for Name: person; Type: TABLE DATA; Schema: public; Owner: xpopelka
--

INSERT INTO person VALUES (22, 'axeMan', 'Tristan', 'Gory', 20, '1968-08-21', 194, 'male');
INSERT INTO person VALUES (21, 'Sony', 'Sonny', 'Lona', 19, '1982-06-19', 160, 'male');
INSERT INTO person VALUES (23, 'Clock-Master', 'Lincoln', 'Wingert', 21, '1975-11-18', 185, 'male');
INSERT INTO person VALUES (27, 'Emiii4x4', 'Barton', 'Slonaker', 24, '1972-02-15', 177, 'male');
INSERT INTO person VALUES (32, 'Leclaire', 'Marcel', 'Miranda', 28, '1976-11-28', NULL, 'male');
INSERT INTO person VALUES (33, 'Gene', 'Dion', 'Leclaire', 29, '1977-12-21', 163, 'male');
INSERT INTO person VALUES (41, 'zachy', 'Zachery', 'Figueiredo', 37, '1982-07-07', 175, 'male');
INSERT INTO person VALUES (40, 'LouReed', 'Reed', 'Judah', 36, '1986-05-11', 190, 'male');
INSERT INTO person VALUES (16, 'Fucha', 'Tuan', 'Fuchs', 20, '1952-11-02', 168, 'male');
INSERT INTO person VALUES (39, 'Swordy', 'Justin', 'Wess', 35, '1967-09-08', 178, 'male');
INSERT INTO person VALUES (17, 'Oshi', 'Karl', 'Oshiro', 16, '1980-12-20', 177, 'male');
INSERT INTO person VALUES (38, '8al', 'Florentino', 'Balfour', 34, '1966-03-16', 173, 'male');
INSERT INTO person VALUES (5, 'Teague', 'Karl', 'Oshiro', 5, '1980-03-09', NULL, 'male');
INSERT INTO person VALUES (4, 'Bertie', 'Everett', 'Hilbert', 4, '1983-05-25', 172, 'male');
INSERT INTO person VALUES (3, 'Tungsten', 'Tuan', 'Brauer', 3, '1982-01-20', 180, 'male');
INSERT INTO person VALUES (9, 'BigBill', 'Bill', 'Crandall', 9, '1982-02-24', 175, 'male');
INSERT INTO person VALUES (10, 'Usher', 'Roderick', 'Colangelo', 10, '1981-05-13', NULL, 'male');
INSERT INTO person VALUES (15, 'TommyGun', 'Thomas', 'Dowdle', 14, '1989-12-01', 162, 'male');
INSERT INTO person VALUES (14, 'Lungs', 'Rolando', 'Lung', 13, '1974-11-29', 178, 'male');
INSERT INTO person VALUES (45, 'Kami', 'Dexter', 'Pagano', NULL, NULL, NULL, 'male');
INSERT INTO person VALUES (49, 'hiromi', 'Carl', 'Oshiro', NULL, NULL, NULL, 'male');
INSERT INTO person VALUES (24, 'Petal', 'Leonora', 'Nisbet', 21, '1978-05-26', 172, 'female');
INSERT INTO person VALUES (46, 'Agan', 'Opal', 'Bagg', NULL, NULL, 183, 'female');
INSERT INTO person VALUES (26, 'Spacey', 'Leonora', 'Nisbet', NULL, '1971-01-12', 185, 'female');
INSERT INTO person VALUES (47, 'Francis', 'Francoise', 'Wood', NULL, '1980-03-12', NULL, 'female');
INSERT INTO person VALUES (25, 'Know$y', 'Janey', 'Knowlton', 22, '1985-11-09', 165, 'female');
INSERT INTO person VALUES (29, 'hilary', 'Remona', 'Deen', 25, NULL, 170, 'female');
INSERT INTO person VALUES (30, 'Igneess', 'Lisette', 'Siqueiros', 26, NULL, 170, 'female');
INSERT INTO person VALUES (28, 'Summers', 'Gilda', 'Summer', 24, '1973-03-18', 168, 'female');
INSERT INTO person VALUES (31, 'hali', 'Alisha', 'Householder', 27, '1981-10-24', 168, 'female');
INSERT INTO person VALUES (34, 'Kiiny', 'Ericka', 'Kreiner', 30, '1978-06-30', 182, 'female');
INSERT INTO person VALUES (1, 'Ethy', 'Ethyl', 'Herren', 34, '1968-09-06', 164, 'female');
INSERT INTO person VALUES (2, 'Gumby', 'Temple ', 'Gumbs', 2, NULL, 184, 'female');
INSERT INTO person VALUES (37, 'cutty', 'Nelia', 'Cutter', 33, '1965-02-12', 169, 'female');
INSERT INTO person VALUES (36, 'pPhil', 'Phyliss', 'Metheny', 32, '1980-05-16', 166, 'female');
INSERT INTO person VALUES (35, 'fox', 'Meagan', 'Holst', 31, '1979-12-31', 176, 'female');
INSERT INTO person VALUES (7, 'mara', 'Maddie', 'Rankins', 7, '1979-10-11', 185, 'female');
INSERT INTO person VALUES (6, 'Kaneshiro', 'Glennie', 'Hottinger', 6, '1982-10-20', 161, 'female');
INSERT INTO person VALUES (8, 'Toledo', 'Earlie', 'Toledo', 8, '1986-04-29', 194, 'female');
INSERT INTO person VALUES (11, 'Alice', 'Alycia', 'Barrientos', 11, '1984-06-14', 180, 'female');
INSERT INTO person VALUES (13, 'january', 'Jesica', 'Callender', 12, '1964-10-09', 174, 'female');
INSERT INTO person VALUES (12, 'Julerd', 'Julissa', 'Erdmann', 10, '1985-07-27', 173, 'female');
INSERT INTO person VALUES (42, 'Tanaka', 'Goldie', 'Steen', 39, '1985-01-13', 181, 'female');
INSERT INTO person VALUES (20, 'Bessie', 'Bess', 'Mckay', 19, '1979-09-30', 159, 'female');
INSERT INTO person VALUES (19, 'Arlene', 'Arlette', 'Woodford', 18, '1946-01-15', NULL, 'female');
INSERT INTO person VALUES (18, 'Magnolia', 'Twyla', 'Maglione', 17, '1942-07-16', 180, 'female');
INSERT INTO person VALUES (43, 'homa', 'Hong', 'Maday', 40, '1980-05-16', 164, 'male');


--
-- Data for Name: person_meeting; Type: TABLE DATA; Schema: public; Owner: xpopelka
--

INSERT INTO person_meeting VALUES (1, 1);
INSERT INTO person_meeting VALUES (2, 1);
INSERT INTO person_meeting VALUES (3, 1);
INSERT INTO person_meeting VALUES (4, 1);
INSERT INTO person_meeting VALUES (5, 1);
INSERT INTO person_meeting VALUES (2, 2);
INSERT INTO person_meeting VALUES (3, 2);
INSERT INTO person_meeting VALUES (4, 3);
INSERT INTO person_meeting VALUES (32, 3);
INSERT INTO person_meeting VALUES (5, 4);
INSERT INTO person_meeting VALUES (29, 4);
INSERT INTO person_meeting VALUES (6, 5);
INSERT INTO person_meeting VALUES (7, 5);
INSERT INTO person_meeting VALUES (8, 6);
INSERT INTO person_meeting VALUES (10, 6);
INSERT INTO person_meeting VALUES (12, 6);
INSERT INTO person_meeting VALUES (14, 6);
INSERT INTO person_meeting VALUES (24, 6);
INSERT INTO person_meeting VALUES (25, 6);
INSERT INTO person_meeting VALUES (29, 6);
INSERT INTO person_meeting VALUES (34, 6);
INSERT INTO person_meeting VALUES (35, 6);
INSERT INTO person_meeting VALUES (36, 6);
INSERT INTO person_meeting VALUES (38, 6);
INSERT INTO person_meeting VALUES (13, 7);
INSERT INTO person_meeting VALUES (17, 7);
INSERT INTO person_meeting VALUES (20, 7);
INSERT INTO person_meeting VALUES (22, 7);
INSERT INTO person_meeting VALUES (26, 7);
INSERT INTO person_meeting VALUES (28, 7);
INSERT INTO person_meeting VALUES (31, 7);
INSERT INTO person_meeting VALUES (32, 7);
INSERT INTO person_meeting VALUES (33, 7);
INSERT INTO person_meeting VALUES (3, 8);
INSERT INTO person_meeting VALUES (4, 8);
INSERT INTO person_meeting VALUES (5, 8);
INSERT INTO person_meeting VALUES (6, 8);
INSERT INTO person_meeting VALUES (7, 8);
INSERT INTO person_meeting VALUES (8, 8);
INSERT INTO person_meeting VALUES (10, 8);
INSERT INTO person_meeting VALUES (15, 9);
INSERT INTO person_meeting VALUES (16, 10);
INSERT INTO person_meeting VALUES (34, 10);
INSERT INTO person_meeting VALUES (1, 11);
INSERT INTO person_meeting VALUES (15, 11);
INSERT INTO person_meeting VALUES (39, 11);
INSERT INTO person_meeting VALUES (40, 11);
INSERT INTO person_meeting VALUES (41, 11);
INSERT INTO person_meeting VALUES (13, 12);
INSERT INTO person_meeting VALUES (17, 12);
INSERT INTO person_meeting VALUES (22, 12);
INSERT INTO person_meeting VALUES (34, 12);
INSERT INTO person_meeting VALUES (35, 12);
INSERT INTO person_meeting VALUES (36, 12);
INSERT INTO person_meeting VALUES (4, 13);
INSERT INTO person_meeting VALUES (33, 13);
INSERT INTO person_meeting VALUES (15, 14);
INSERT INTO person_meeting VALUES (16, 14);
INSERT INTO person_meeting VALUES (21, 14);
INSERT INTO person_meeting VALUES (24, 14);
INSERT INTO person_meeting VALUES (32, 14);
INSERT INTO person_meeting VALUES (33, 14);
INSERT INTO person_meeting VALUES (34, 14);
INSERT INTO person_meeting VALUES (35, 14);
INSERT INTO person_meeting VALUES (36, 14);
INSERT INTO person_meeting VALUES (41, 14);
INSERT INTO person_meeting VALUES (3, 15);
INSERT INTO person_meeting VALUES (37, 15);
INSERT INTO person_meeting VALUES (5, 16);
INSERT INTO person_meeting VALUES (30, 16);
INSERT INTO person_meeting VALUES (5, 17);
INSERT INTO person_meeting VALUES (6, 17);
INSERT INTO person_meeting VALUES (14, 17);
INSERT INTO person_meeting VALUES (15, 17);
INSERT INTO person_meeting VALUES (30, 17);
INSERT INTO person_meeting VALUES (31, 17);
INSERT INTO person_meeting VALUES (32, 17);
INSERT INTO person_meeting VALUES (39, 17);
INSERT INTO person_meeting VALUES (11, 18);
INSERT INTO person_meeting VALUES (18, 18);
INSERT INTO person_meeting VALUES (19, 18);
INSERT INTO person_meeting VALUES (23, 18);
INSERT INTO person_meeting VALUES (27, 18);
INSERT INTO person_meeting VALUES (33, 18);


--
-- Data for Name: relation_type; Type: TABLE DATA; Schema: public; Owner: xpopelka
--

INSERT INTO relation_type VALUES (1, 'friend');
INSERT INTO relation_type VALUES (2, 'enemy');
INSERT INTO relation_type VALUES (3, 'partner');
INSERT INTO relation_type VALUES (4, 'colleague');
INSERT INTO relation_type VALUES (5, 'acquaintance');
INSERT INTO relation_type VALUES (6, 'lover');
INSERT INTO relation_type VALUES (7, 'family');
INSERT INTO relation_type VALUES (8, 'spouse');


--
-- Data for Name: relation; Type: TABLE DATA; Schema: public; Owner: xpopelka
--

INSERT INTO relation VALUES (1, 20, 21, '', 8);
INSERT INTO relation VALUES (2, 23, 24, '', 8);
INSERT INTO relation VALUES (5, 5, 36, '', 8);
INSERT INTO relation VALUES (7, 20, 12, '', 7);
INSERT INTO relation VALUES (8, 18, 16, '', 7);
INSERT INTO relation VALUES (9, 10, 29, '', 7);
INSERT INTO relation VALUES (10, 11, 30, '', 7);
INSERT INTO relation VALUES (11, 11, 35, '', 7);
INSERT INTO relation VALUES (12, 14, 24, '', 7);
INSERT INTO relation VALUES (13, 3, 25, '', 7);
INSERT INTO relation VALUES (14, 1, 24, '', 4);
INSERT INTO relation VALUES (15, 1, 25, '', 4);
INSERT INTO relation VALUES (16, 2, 26, '', 4);
INSERT INTO relation VALUES (17, 2, 30, '', 4);
INSERT INTO relation VALUES (18, 2, 35, '', 4);
INSERT INTO relation VALUES (21, 3, 16, '', 4);
INSERT INTO relation VALUES (22, 3, 24, '', 4);
INSERT INTO relation VALUES (23, 3, 32, '', 4);
INSERT INTO relation VALUES (24, 3, 36, '', 4);
INSERT INTO relation VALUES (25, 4, 15, '', 4);
INSERT INTO relation VALUES (26, 4, 21, '', 4);
INSERT INTO relation VALUES (27, 4, 23, '', 4);
INSERT INTO relation VALUES (28, 4, 12, '', 4);
INSERT INTO relation VALUES (29, 5, 17, '', 4);
INSERT INTO relation VALUES (30, 5, 19, '', 4);
INSERT INTO relation VALUES (32, 5, 29, '', 4);
INSERT INTO relation VALUES (33, 5, 32, '', 4);
INSERT INTO relation VALUES (34, 5, 34, '', 4);
INSERT INTO relation VALUES (35, 6, 17, '', 4);
INSERT INTO relation VALUES (36, 6, 19, '', 4);
INSERT INTO relation VALUES (37, 8, 22, '', 4);
INSERT INTO relation VALUES (38, 11, 35, '', 6);
INSERT INTO relation VALUES (39, 11, 36, '', 6);
INSERT INTO relation VALUES (41, 6, 36, '', 6);
INSERT INTO relation VALUES (42, 1, 30, '', 6);
INSERT INTO relation VALUES (43, 15, 29, '', 6);
INSERT INTO relation VALUES (44, 2, 32, '', 1);
INSERT INTO relation VALUES (45, 9, 21, '', 1);
INSERT INTO relation VALUES (46, 10, 21, '', 1);
INSERT INTO relation VALUES (47, 15, 21, '', 1);
INSERT INTO relation VALUES (48, 2, 25, '', 1);
INSERT INTO relation VALUES (49, 2, 27, '', 1);
INSERT INTO relation VALUES (50, 10, 27, '', 1);
INSERT INTO relation VALUES (51, 11, 26, '', 1);
INSERT INTO relation VALUES (52, 12, 25, '', 1);
INSERT INTO relation VALUES (53, 12, 27, '', 1);
INSERT INTO relation VALUES (54, 12, 28, '', 1);
INSERT INTO relation VALUES (55, 13, 31, '', 1);
INSERT INTO relation VALUES (56, 14, 33, '', 1);
INSERT INTO relation VALUES (57, 16, 22, '', 1);
INSERT INTO relation VALUES (58, 17, 31, '', 1);
INSERT INTO relation VALUES (59, 17, 34, '', 1);
INSERT INTO relation VALUES (60, 18, 37, '', 1);
INSERT INTO relation VALUES (61, 18, 22, '', 1);
INSERT INTO relation VALUES (62, 18, 29, '', 1);
INSERT INTO relation VALUES (63, 19, 31, '', 1);
INSERT INTO relation VALUES (64, 19, 38, '', 1);
INSERT INTO relation VALUES (65, 20, 27, '', 1);
INSERT INTO relation VALUES (68, 35, 36, '', 1);
INSERT INTO relation VALUES (69, 30, 31, '', 1);
INSERT INTO relation VALUES (70, 21, 34, '', 1);
INSERT INTO relation VALUES (71, 21, 35, '', 1);
INSERT INTO relation VALUES (72, 22, 23, '', 1);
INSERT INTO relation VALUES (73, 17, 34, '', 5);
INSERT INTO relation VALUES (74, 18, 37, '', 5);
INSERT INTO relation VALUES (76, 18, 29, '', 5);
INSERT INTO relation VALUES (77, 19, 31, '', 5);
INSERT INTO relation VALUES (78, 19, 38, '', 5);
INSERT INTO relation VALUES (79, 20, 27, '', 5);
INSERT INTO relation VALUES (80, 21, 27, '', 5);
INSERT INTO relation VALUES (81, 31, 34, '', 5);
INSERT INTO relation VALUES (82, 1, 21, '', 2);
INSERT INTO relation VALUES (83, 3, 23, '', 2);
INSERT INTO relation VALUES (84, 5, 24, '', 2);
INSERT INTO relation VALUES (86, 7, 32, '', 2);
INSERT INTO relation VALUES (87, 7, 34, '', 2);
INSERT INTO relation VALUES (89, 5, 34, '', 2);
INSERT INTO relation VALUES (90, 1, 24, '', 2);
INSERT INTO relation VALUES (4, 3, 37, '12.3.2015', 8);
INSERT INTO relation VALUES (6, 6, 3, '4.9.2014', 8);
INSERT INTO relation VALUES (3, 1, 39, '23.5.2016', 8);
INSERT INTO relation VALUES (19, 2, 6, 'school', 4);
INSERT INTO relation VALUES (20, 2, 8, 'school', 4);
INSERT INTO relation VALUES (31, 5, 22, 'school', 4);
INSERT INTO relation VALUES (40, 5, 34, 'not sure', 6);
INSERT INTO relation VALUES (67, 31, 34, 'hiking', 1);
INSERT INTO relation VALUES (66, 21, 27, 'hiking', 1);
INSERT INTO relation VALUES (75, 18, 22, 'hiking', 5);
INSERT INTO relation VALUES (85, 6, 28, 'owes 15k', 2);
INSERT INTO relation VALUES (88, 6, 34, 'owes 54k', 2);


--
-- PostgreSQL database dump complete
--

