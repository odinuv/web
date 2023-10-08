---
title: FAQ - Frequently asked questions
permalink: /course/faq/
---

* TOC
{:toc}

This place should navigate you quickly to important sections and tries to gather answers for questions of typical
beginner. If you have any other question and you think that it should be answered here, mail [me](mailto:jan.kolomaznik@mendelu.cz).

## Course and project related questions

### Can I have custom project assignment?
It is possible to have a different assignment, but it has to be equally (or more) challenging as the default one.
It has to use some database and it has to be implemented as a web application. Always consult alternative assignment
with me.

### Can I use different programming language?
Of course you can, but you have to write the project in a *modern* way. It means that you should use some framework,
templating engine etc. 

### I am stuck with something, can I use help from a friend?
You are free to consult the project with anybody. Anyhow, the best bet is to ask me for help if you got really stuck.
There is a chance that if you ask some of your more skilled friends who already solved the problem by "reinventing
the wheel" that you will learn some bad habit. Some problems are very easy to solve but you have to be aware of certain
methods -- a good example is the problem of [last insert ID value](/walkthrough-slim/backend-insert/advanced/).

### I am stuck with something, can I use some piece of source code from a friend?
Yes, but be careful. Your project will be considered as plagiarism if you copy more code than you wrote by yourself!
Always remember to reference the original author!

~~~ php?start_inline=1
//this code is from student XYZ (xyz@mendelu.cz)
function countRows(PDO $db, $table) {
    $stmt = $db->query('SELECT COUNT(*) AS cnt FROM ' . $table);
    return $stmt->fetch()['cnt'];
}
~~~

### Do I need to complete the course project before attending exam?
It is recommended but you can present the project after your exam. Be aware that most of your classmates will have
similar reasoning and they will postpone the presentation date as late as possible. It can happen, that few last
days before the submission deadline will be crowded with project presentations and you will not manage to present
your work in time.

### How do I know that my project is OK?
First of all, try to use it. Every application has to be tested by a user (you or somebody else). Write down some
scenarios (create a person with/without location, add multiple contacts to that person, move a person to another
location, create a meeting and invite people, ...) and try to perform them. You will see whether the app allows such
actions to be executed and how smoothly they are carried out.

Keep in mind these key points when you design the application:
- somebody will use it from scratch (almost empty database).
- somebody will use it for two, three, four ... or even more years.
- you want to install (sell) as many copies as possible to different users. They will have different
  requirement on contact/relation types.

### Lookup tables
Those tables called `contact_type` and `relation_type` are *lookup tables*. They are there to customize the application
for different users (different instances of the same application). You should load records from them whenever you need
to specify contact or relation type in a form. Do not retype values from these tables into templates. If you do not
like that records in these tables are in English, change them to any other language in Adminer.

Wrong - this code does not reflect potential changes in lookup table:

~~~ html
<select name="idct">
    <option value="1">Facebook</option>
    <option value="2">Skype</option>
    <option value="...">...</option>
</select>
~~~

Correct:

~~~ php?start_inline=1
try {
    $stmt = $this->db->query('SELECT * FROM contact_type ORDER BY name');
    $tplVars['types'] = $stmt->fetchAll();
} catch (Exception $e) {
    //log or show
}
~~~

~~~ html
<select name="idct">
    {foreach $types as $t}
    <option value="{$t['id_contact_type']}">{$t['name']}</option>
    {/foreach}
</select>
~~~

## Questions (almost) impossible to answer

### How does it all work together? I have written (copied) all the code, it sort-of works, but I do not know why!
Well, working web application is a complicated thing. Do not trust anybody who tells you opposite. You have to know
quite a lot of technologies (e.g. HTTP, HTML, CSS, PHP, SQL and a bit of JavaScript) to build one. The advantage of
web technologies is that you only need a text-editor to code a HTML page or PHP script.

You have to study all building blocks separately and then connect all the ends together. Start with plain
[HTML](/walkthrough-slim/html-forms/), then try plain [PHP](/walkthrough-slim/backend-intro/), then generate some HTML
code in PHP script. Important part are [HTML forms](/walkthrough-slim/html-forms/) and [receiving values](/walkthrough-slim/backend-intro/receiving-values/).
Mix in some [templating engine](/walkthrough-slim/templates/) magic, add a [framework](/walkthrough-slim/slim-intro/)
and you are good to go. There is no simple answer for this, you have to study.

### Should I use framework/library A instead of framework/library B, why you teach us Slim and Latte?
Well it depends... on lot of things (e.g. state and quality of documentation, state of development -- is it still beta,
size of developer community, how deeply is the technology rooted in community, is it new or old...). I tried to choose
simple technologies which will give you a good start to learn more advanced ones later (especially frameworks).

Slim framework is simple and it suits very well for our task. For bigger application it would be better to use something
more sophisticated. Great advantage of Slim is that everything it does is traceable, there is very little magic --
e.g. database, logger and templating engine are defined in `src/dependencies.php` file. *Request* or *Response* objects
used as parameters of route handlers are [well](https://www.slimframework.com/docs/v3/objects/request.html)
[documented](https://www.slimframework.com/docs/v3/objects/response.html) and they are there to access *input* and
*output* of PHP script in object-oriented fashion. The [middleware](https://www.slimframework.com/docs/v3/concepts/middleware.html)
mechanism is also very transparent.

Latte has very convenient syntax and good support in various editors (compare with syntax of [Blade](https://laravel.com/docs/5.6/blade) --
those `@` macros look weird to me). Latte is also very secure and quite fast. Nevertheless the templating engines are
all alike.

### My code is different than someone else's, how is that possible?
There are multiple ways how to implement anything. It is OK to have your own way. Always try to read and understand code
of other people, you can either enrich yourself with new knowledge or help somebody else. In the end, the user is most
interested whether your application works or not. 

## General questions

### How to start working on the project?
Simple answer is: have a plan! The more complicated answer follows. The [walkthrough](/walkthrough-slim/) section covers
only one module of the application -- the person module (list, add, edit and delete actions). This module is obviously
crucial but to fulfill the [project assignment](/course/#project-assignment) you have to do much more. A good idea is
to write down all actions that you want to enable for users of your application before you start writing any
code -- a list or nested list is OK, [UML Use-Case diagram](https://en.wikipedia.org/wiki/Use_case) is better. You can
also identify user roles (like administrator, registered user or guest). Use-Case diagram includes user roles by its
nature.

{: .note}
You can use dedicated software to draw UML diagrams. Try [Visual Paradigm](https://www.visual-paradigm.com/)
or [Dia](http://dia-installer.de/) or just pencil and paper.

Here is an example of a Use-Case diagram made with [PlantUML](http://plantuml.com):

{: .image-popup}
<div>
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
     contentScriptType="application/ecmascript" contentStyleType="text/css" height="511px" preserveAspectRatio="none"
     style="width:618px;height:511px;background:#FFFFF0;" version="1.1" viewBox="0 0 618 511" width="618px"
     zoomAndPan="magnify">
    <defs>
        <filter height="300%" id="fdpvykvof5mlx" width="300%" x="-1" y="-1">
            <feGaussianBlur result="blurOut" stdDeviation="2.0"/>
            <feColorMatrix in="blurOut" result="blurOut2" type="matrix"
                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 .4 0"/>
            <feOffset dx="4.0" dy="4.0" in="blurOut2" result="blurOut3"/>
            <feBlend in="SourceGraphic" in2="blurOut3" mode="normal"/>
        </filter>
    </defs>
    <g>
        <text fill="#000000" font-family="sans-serif" font-size="18" lengthAdjust="spacingAndGlyphs" textLength="243"
              x="191.5" y="16.708">Person directory Use-Cases
        </text><!--entity guest-->
        <polygon fill="#FEFECE" filter="url(#fdpvykvof5mlx)"
                 points="34.4326,385.0483,33.8036,387.824,32.7357,388.8748,30.7374,389.9083,29.0002,390.2816,27.5532,390.648,25.7552,391.0102,23.7797,390.3832,22.2213,389.3422,21.3946,387.9896,19.3411,386.0482,19.1535,384.0218,18.5166,382.4831,19.459,380.296,20.2889,378.3907,21.4205,377.4311,22.1742,375.9649,24.1105,375.6704,26.5022,375.3317,28.9351,375.6122,31.4593,376.0906,32.9524,378.3101,34.3016,380.4888,34.4804,381.8999,34.7772,383.3974"
                 style="stroke: #A80036; stroke-width: 2.0;"/>
        <path d="M27,390.9531 L26.8681,390.9531 L26.8647,396.3531 L26.3497,401.7531 L27.3524,407.1531 L27.2577,412.5531 L27,417.9531 M14,398.9531 L14,399.0061 L19.2,398.6956 L24.4,398.6148 L29.6,398.6618 L34.8,399.1275 L40,398.9531 M27,417.9531 L26.7906,417.7716 L24.3885,420.9431 L22.0398,424.1609 L18.8304,426.6328 L16.806,430.1316 L14,432.9531 M27,417.9531 L26.5557,417.5681 L29.8844,421.1996 L32.4446,424.1652 L34.9236,427.0602 L37.6198,430.1436 L40,432.9531 "
              fill="none" filter="url(#fdpvykvof5mlx)" style="stroke: #A80036; stroke-width: 2.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="42"
              x="6" y="452.9482">Guest
        </text><!--entity user-->
        <polygon fill="#FEFECE" filter="url(#fdpvykvof5mlx)"
                 points="171.8003,246.3077,171.3801,247.9127,170.0631,249.2408,169.3388,250.7713,167.7374,251.1767,166.2043,251.6007,164.2639,251.767,161.7853,251.2072,160.0825,251.1796,158.7579,249.6915,157.2228,248.2234,157.1416,245.4241,156.1342,243.4441,157.2265,241.9247,157.4483,240.0516,158.5588,238.6926,160.6413,236.9548,162.9165,235.929,165.4425,235.6931,167.5675,236.8283,169.2857,237.4044,170.272,238.6701,171.6841,240.7927,172.1463,242.3035,172.8111,244.4959"
                 style="stroke: #A80036; stroke-width: 2.0;"/>
        <path d="M164.5,251.9531 L164.8417,251.9531 L164.212,257.3531 L164.4893,262.7531 L164.5087,268.1531 L164.2938,273.5531 L164.5,278.9531 M151.5,259.9531 L151.5,260.4562 L156.7,260.6009 L161.9,259.5885 L167.1,259.568 L172.3,260.4656 L177.5,259.9531 M164.5,278.9531 L164.4536,278.9129 L161.7687,281.8393 L158.8406,284.5549 L157.1228,288.3196 L154.5712,291.3615 L151.5,293.9531 M164.5,278.9531 L164.6121,279.0503 L167.3314,282.1536 L169.6128,284.8776 L172.1309,287.8066 L174.9451,290.9922 L177.5,293.9531 "
              fill="none" filter="url(#fdpvykvof5mlx)" style="stroke: #A80036; stroke-width: 2.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="111"
              x="109" y="313.9482">Registered user
        </text>
        <polygon fill="#FEFECE" filter="url(#fdpvykvof5mlx)"
                 points="368.8304,416.8636,367.5414,419.1863,363.6362,420.8753,360.694,423.0383,355.8597,424.6562,350.4781,426.0934,344.9185,427.3927,338.7453,428.3333,332.6508,429.0702,324.7571,428.9162,318.9336,429.0877,311.4737,428.31,305.8871,427.6999,298.8065,426.1157,294.465,424.936,288.7571,422.7996,286.3221,421.2436,283.4303,419.0559,281.4079,416.7046,280.6852,414.3729,280.9654,412.0145,282.7748,409.8635,285.0101,407.6235,289.2108,405.8757,293.4154,404.0501,299.5844,402.8727,304.7114,401.4306,311.439,400.673,317.3519,399.8761,324.6812,399.8439,332.7415,400.4105,338.5885,400.656,345.2727,401.6283,350.8025,402.7007,356.9151,404.4649,360.6121,405.9378,364.8946,408.1034,366.2713,409.791,367.8505,411.9962,369.5212,414.6407"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="58"
              x="296.0122" y="419.1252">Register
        </text>
        <polygon fill="#FEFECE" filter="url(#fdpvykvof5mlx)"
                 points="353.6173,487.5747,352.9495,489.9902,350.9973,491.9956,348.3738,493.8231,345.2288,495.4699,341.7536,496.9523,338.8347,498.6326,334.1741,499.2892,330.1193,500.0179,325.3633,500.1001,320.3054,499.6744,315.8383,499.1338,311.3958,498.1547,308.4441,497.4371,304.729,495.8398,301.6819,494.0694,299.1512,492.0567,296.9764,489.7402,296.467,487.8025,296.5131,485.7323,296.4185,483.2344,297.2369,480.8939,298.968,478.7783,301.0623,476.6873,305.0833,475.4768,308.1125,473.7722,311.6468,472.3984,316.4969,471.8362,320.2192,470.9419,325.6021,471.1718,329.9623,471.2501,333.7034,471.4292,338.3177,472.4938,342.424,473.7864,346.3257,475.4766,348.9058,477.0144,350.7592,478.6899,352.732,480.9058,353.4572,482.951,354.6729,485.6496"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="37"
              x="306.663" y="490.1252">Login
        </text>
        <polygon fill="#FEFECE" filter="url(#fdpvykvof5mlx)"
                 points="582.6396,46.6432,579.6617,48.8298,577.6564,51.4888,572.1833,53.4896,563.9564,54.9205,556.4598,56.5245,547.6657,57.7375,538.6491,58.7332,528.7768,59.2841,518.4175,59.4065,507.945,59.1257,499.0034,58.7772,490.7445,58.1163,479.9935,56.3579,473.6168,55.1113,466.1583,53.0756,461.9255,51.2794,457.9637,49.041,454.8442,46.5281,455.0545,44.3744,455.9328,42.0027,457.3329,39.4418,461.2651,37.2399,467.2575,35.3623,472.8496,33.3064,480.3311,31.6987,488.4138,30.317,497.917,29.4367,508.665,29.0935,518.621,28.8754,529.0364,29.1428,537.6556,29.4147,548.6258,30.7188,557.1709,31.954,564.2961,33.3781,571.2508,35.2943,577.1529,37.4866,580.9492,39.6857,583.2594,42.0066,582.713,44.0805"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="92"
              x="472.9486" y="48.8913">Add a person
        </text>
        <polygon fill="#FEFECE" filter="url(#fdpvykvof5mlx)"
                 points="593.4526,207.21,589.3209,209.5157,583.7213,211.7531,578.4221,214.2461,572.7988,216.7577,563.2795,218.3643,553.5014,219.8168,541.3422,220.5304,530.0808,221.1797,519.8621,221.7181,506.4887,221.0986,496.2124,220.7124,484.2486,219.3988,473.9472,217.8997,467.322,216.6611,459.1153,214.4542,453.3905,212.2302,448.8397,209.7075,444.9078,206.793,444.9387,204.3129,444.1014,201.2062,448.8071,199.0339,453.8556,196.6685,458.7219,194.0749,465.7149,191.8815,474.3389,190.0669,486.3691,189.1376,495.3466,187.6849,507.8804,187.3311,517.8144,186.7266,531.2581,187.3624,542.3913,187.9477,552.1869,188.7577,562.882,190.3481,572.4349,192.2669,580.02,194.3294,585.2036,196.4276,589.602,198.915,591.5043,201.358,593.506,204.3103"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="117"
              x="460.2894" y="208.8594">Show all persons
        </text>
        <polygon fill="#FEFECE" filter="url(#fdpvykvof5mlx)"
                 points="592.0207,278.3339,589.9749,281.0923,585.295,283.5082,578.1791,285.5412,571.1768,287.6938,562.6769,289.498,551.5335,290.5939,541.0569,291.6611,530.0736,292.3402,517.9495,292.4039,506.064,292.1022,496.2461,291.8,486.8899,291.0748,476.8956,289.635,468.2302,287.9166,459.8418,285.6672,452.224,283.0092,448.8637,280.7757,446.353,278.2095,446.9498,275.8847,447.2895,273.0791,448.9553,270.2322,452.9336,267.6531,458.4343,265.2443,468.1596,263.7252,476.7569,261.9438,484.7471,260.1141,497.0726,259.4771,508.1819,258.8274,519.9152,258.6728,531.1252,258.8173,540.4762,259.0109,551.746,260.1813,561.3226,261.5239,569.4658,263.1209,577.3844,265.2609,584.9493,267.9065,589.7184,270.4679,591.8054,272.9355,592.4214,275.5425"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="115"
              x="461.4711" y="280.1958">Update a person
        </text>
        <polygon fill="#FEFECE" filter="url(#fdpvykvof5mlx)"
                 points="590.461,348.9975,586.5376,351.2548,582.3872,353.7243,578.1546,356.355,568.3998,357.7883,561.3282,359.8477,551.0784,361.074,541.7364,362.3318,530.4883,362.8795,517.785,362.7444,507.3074,362.7158,496.9992,362.2543,487.4096,361.4402,476.3623,359.7305,469.341,358.3837,461.8276,356.338,453.4448,353.5127,449.8836,351.2573,449.2173,349.1573,446.5241,346.1118,448.2567,343.6864,451.5838,341.2899,453.6843,338.3419,461.0558,336.4438,467.1031,334.1453,475.8151,332.4687,486.4001,331.3206,497.9323,330.574,508.9445,329.9712,518.6412,329.4046,530.3377,329.7177,540.8194,330.2197,551.0832,331.1912,560.2408,332.4598,570.7735,334.6262,578.0137,336.6081,582.7043,338.5717,587.5862,341.1353,588.9539,343.399,591.1092,346.3189"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="111"
              x="463.3489" y="350.8713">Delete a person
        </text>
        <polygon fill="#FEFECE" filter="url(#fdpvykvof5mlx)"
                 points="607.5161,134.9979,604.768,138.1882,598.6976,140.943,591.2885,143.6107,580.1199,145.5348,569.3399,147.5471,560.3594,149.8581,545.8249,150.6912,533.5645,151.722,517.3978,151.4533,505.2419,151.5988,489.9471,150.4638,478.0014,149.4637,467.4465,148.1117,455.3253,145.7108,446.6047,143.38,438.5033,140.4965,433.4163,137.6297,429.3858,134.3772,428.8451,131.3492,431.3089,128.507,433.3483,125.1557,439.0901,122.3263,446.8078,119.7286,456.8873,117.5573,464.9568,114.9297,477.0425,113.3237,491.9963,112.5857,503.5464,111.3937,520.0279,111.7338,532.066,111.5616,547.5172,112.7321,558.6238,113.5417,570.2185,115.1297,582.2817,117.5175,589.9242,119.6035,598.2412,122.536,601.6728,125.027,607.0463,128.5843,606.0251,131.2577"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="151"
              x="443.2915" y="136.2599">Add person's address
        </text><!--link guest to user-->
        <path d="M62.2611,379.3071 L62.1183,379.1679 L69.5462,372.9364 L75.5265,365.2938 L82.1724,358.3001 L89.5596,352.029 L96.2052,345.0349 L102.9395,338.1274 L109.3505,330.9046 L116.2172,324.1261 L122.867,317.1361 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0;"/>
        <polygon fill="none"
                 points="67.2589,384.2081,67.1525,383.9941,63.4705,386.1076,59.5946,387.8313,55.8832,389.8856,52.1521,391.9004,48.2857,393.6431,48.2525,393.6277,50.1165,389.8209,51.8407,385.949,53.5202,382.0563,55.2969,378.2088,57.234,374.4361,57.3916,374.5978,59.2368,376.3883,61.3255,378.4285,63.1288,380.1761,65.254,382.2538,67.2589,384.2081"
                 style="stroke: #A80036; stroke-width: 1.0;"/><!--link guest to Register-->
        <path d="M48.3453,414.4531 L48.3453,414.0895 L58.2388,415.3309 L68.1322,414.4897 L78.0257,413.9027 L87.9192,414.8616 L97.8126,413.9679 L107.7061,413.8688 L117.5996,414.071 L127.493,415.3473 L137.3865,413.7168 L147.28,414.3636 L157.1734,413.606 L167.0669,415.0487 L176.9603,414.085 L186.8538,414.5329 L196.7473,413.6851 L206.6407,413.7181 L216.5342,415.1321 L226.4277,414.6547 L236.3211,414.9832 L246.2146,415.3063 L256.1081,414.2726 L266.0015,415.3304 L275.895,414.4531 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0;"/>
        <polygon fill="#A80036"
                 points="280.936,414.4531,280.8497,414.259,279.1908,413.7764,277.302,412.7766,275.565,412.1184,273.7958,411.3876,271.936,410.4531,271.7707,410.2878,272.6681,411.1853,273.5306,412.0477,274.4353,412.9525,275.272,413.7891,275.936,414.4531,276.0055,414.5227,275.258,415.3752,274.3788,416.0959,273.6015,416.9186,272.5811,417.4982,271.936,418.4531,272.0361,418.6783,273.6408,417.4389,275.5932,416.9819,277.4323,416.2699,279.0935,415.1575,280.936,414.4531"
                 style="stroke: #A80036; stroke-width: 1.0;"/><!--link guest to Login-->
        <path d="M48.3453,419.3332 L48.5437,420.1602 L58.1665,421.7241 L67.8347,423.4773 L77.9658,427.1602 L87.7227,429.2833 L97.273,430.5449 L107.2616,433.6338 L116.8935,435.2358 L126.6683,437.4332 L136.4437,439.6335 L146.6089,443.4587 L156.4071,445.7536 L166.2349,448.1719 L175.774,449.3871 L185.7485,452.417 L195.5066,454.5452 L205.3748,457.1323 L215.0937,459.0964 L225.015,461.905 L234.7905,464.1052 L244.5911,466.4105 L254.1881,467.8667 L264.332,471.6031 L273.8094,472.5609 L283.8899,476.0332 L293.651,478.1734 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0;"/>
        <polygon fill="#A80036"
                 points="298.567,479.3527,298.4433,479.1912,297.0394,478.2025,295.5498,477.1018,293.9316,475.8334,292.2358,474.4635,290.7476,473.3646,290.569,473.2551,291.2096,474.2497,291.8976,475.2734,292.4787,476.2316,293.2266,477.2919,293.7048,478.187,293.7284,478.2256,292.7113,478.7312,291.6528,479.1692,290.8409,480.0095,289.8385,480.539,288.8824,481.1442,288.8712,481.0833,290.7888,480.6209,292.7459,480.3716,294.7325,480.2817,296.5952,479.5226,298.567,479.3527"
                 style="stroke: #A80036; stroke-width: 1.0;"/><!--link user to Add a person-->
        <path d="M220.213,235.5521 L220.0977,235.391 L224.5626,232.7051 L228.7528,229.6351 L232.7924,226.3547 L237.1305,223.4914 L241.3344,220.4408 L241.4889,220.659 L246.1516,217.2907 L250.8679,213.9983 L255.4087,210.4579 L260.0782,207.0992 L264.807,203.8243 L264.685,203.6499 L269.9321,200.3459 L274.9213,196.6732 L280.1339,193.3198 L285.251,189.8299 L290.1839,186.0767 L290.0175,185.8354 L295.7376,182.6466 L300.9626,178.7397 L306.3539,175.0741 L311.5351,171.1037 L317.0185,167.5716 L317.0006,167.5453 L322.6165,163.8365 L328.1787,160.0484 L333.9109,156.5111 L339.1607,152.2627 L344.8641,148.6829 L344.9753,148.85 L350.3669,144.6339 L356.3688,141.335 L361.7699,137.1331 L367.7745,133.8383 L373.274,129.7844 L373.3468,129.8965 L379.0429,126.175 L384.589,122.2227 L390.4807,118.8025 L396.252,115.1968 L401.8016,111.2499 L401.6605,111.0264 L407.425,107.6647 L413.1774,104.2841 L418.6662,100.4856 L424.1981,96.7554 L430,93.4531 L430.0023,93.4569 L432.6612,91.4572 L435.8294,90.2997 L438.4304,88.2041 L441.3112,86.5714 L444.1625,84.8898 L444.0289,84.6593 L447.1352,83.3105 L450.0978,81.7138 L452.9017,79.8432 L455.6946,77.9538 L458.7143,76.4555 L458.7584,76.5343 L461.6721,75.0291 L464.5236,73.4131 L467.1539,71.403 L470.1415,70.0296 L473.0054,68.4358 L473.1157,68.6374 L475.8322,67.2473 L478.5102,65.7868 L480.9079,63.814 L483.7346,62.6252 L486.386,61.1161 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0;"/>
        <polygon fill="#A80036"
                 points="491.049,58.6031,491.061,58.7612,489.1035,58.9967,487.1111,58.7742,485.1393,58.8229,483.1893,59.1569,481.2284,59.3493,481.2331,59.3647,482.3626,59.8427,483.3835,59.9581,484.4409,60.1955,485.58,60.7051,486.6469,60.9741,486.4534,60.9161,486.1254,61.9989,485.9858,63.1382,485.4893,64.1704,485.4526,65.3406,485.0221,66.3926,485.0854,66.4416,486.3287,64.9131,487.6139,63.4169,488.4639,61.584,489.6662,60.0238,491.049,58.6031"
                 style="stroke: #A80036; stroke-width: 1.0;"/><!--link user to Show all persons-->
        <path d="M220.211,257.4681 L220.2237,257.5131 L223.1865,256.5699 L226.1465,255.617 L229.1697,254.8869 L232.2421,254.3304 L235.1606,253.2311 L235.2376,253.5333 L238.0817,252.2918 L241.0609,251.5806 L243.9938,250.6874 L247.1132,250.5273 L250,249.4531 L250.0028,249.4655 L255.0177,248.0224 L260.1569,247.1281 L265.184,245.7389 L270.3933,245.1548 L275.4064,243.7037 L275.4734,244.0254 L280.6237,242.6969 L285.8016,241.5013 L291.0126,240.4642 L296.1558,239.102 L301.4134,238.2886 L301.4118,238.2803 L306.7102,237.5525 L311.8784,236.1502 L317.1781,235.4292 L322.4375,234.4992 L327.6298,233.2217 L327.6401,233.2788 L332.7861,232.0004 L337.9948,231.0694 L343.2752,230.5349 L348.4088,229.1884 L353.6645,228.517 L353.6153,228.2275 L358.7261,227.4702 L363.8107,226.5584 L368.9471,225.9521 L374.0631,225.2251 L379.1264,224.1883 L379.103,224.0429 L384.0492,223.5448 L388.9014,222.4626 L393.872,222.1163 L398.7112,220.9532 L403.6244,220.2497 L403.5891,220.0185 L408.2622,219.6033 L412.8487,218.6209 L417.5068,218.1071 L422.1442,217.4581 L426.7673,216.715 L426.8109,217.0146 L431.0552,216.1504 L435.3321,215.5106 L439.6025,214.8258 L443.8493,213.979 L448.164,213.5981 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0;"/>
        <polygon fill="#A80036"
                 points="453.354,212.8631,453.3809,212.9577,451.5125,212.5094,449.5247,211.6421,447.6402,211.1375,445.7941,210.7677,443.8818,210.1654,443.7466,209.9855,444.7489,210.7957,445.6047,211.411,446.6137,212.2301,447.3695,212.7124,448.4035,213.5646,448.3505,213.5248,447.5739,214.3564,446.8624,215.2369,446.3065,216.2344,445.6571,217.1616,445.0042,218.0863,444.985,218.0555,446.7589,217.1771,448.3909,216.0717,450.0025,214.9338,451.6341,213.8278,453.354,212.8631"
                 style="stroke: #A80036; stroke-width: 1.0;"/><!--link user to Update a person-->
        <path d="M220.191,275.4531 L220.191,274.6365 L230.1951,274.9629 L240.1993,276.1275 L250.2034,274.4808 L260.2075,275.4984 L270.2117,276.4305 L280.2158,275.7268 L290.22,275.4226 L300.2241,274.53 L310.2282,276.208 L320.2324,274.5676 L330.2365,275.7888 L340.2406,274.9759 L350.2448,275.4051 L360.2489,275.3019 L370.253,274.712 L380.2572,275.834 L390.2613,275.0326 L400.2655,274.8567 L410.2696,274.9847 L420.2737,276.1464 L430.2779,275.7301 L440.282,275.4531 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0;"/>
        <polygon fill="#A80036"
                 points="445.437,275.4531,445.3595,275.2787,443.6933,274.7798,441.8154,273.8045,440.0539,273.0913,438.1914,272.1506,436.437,271.4531,436.4469,271.463,437.3277,272.3438,437.8783,272.8944,438.6955,273.7116,439.5678,274.5839,440.437,275.4531,440.2606,275.2767,439.5637,276.1798,438.7369,276.953,437.9859,277.8021,437.2995,278.7156,436.437,279.4531,436.395,279.3587,438.2925,278.7779,440.1248,278.0507,441.7379,276.8302,443.6765,276.3421,445.437,275.4531"
                 style="stroke: #A80036; stroke-width: 1.0;"/><!--link user to Delete a person-->
        <path d="M220.191,286.4691 L220.1402,286.2168 L230.0636,288.1592 L239.9537,289.936 L249.8774,291.8801 L260.0003,294.8128 L269.7923,296.1024 L279.9389,299.1532 L289.6608,300.0949 L299.7933,303.0753 L309.6861,304.8655 L319.6273,306.8964 L329.5201,308.6868 L339.2248,309.543 L349.4625,313.0462 L359.4687,315.3992 L369.2679,316.7251 L379.1973,318.6972 L389.1284,320.6774 L399.0214,322.4691 L408.9806,324.5892 L418.9957,326.9868 L428.9339,329.0026 L438.6986,330.1567 L448.8721,333.3408 L458.637,334.4961 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0;"/>
        <polygon fill="#A80036"
                 points="463.76,335.5281,463.6418,335.3614,462.2052,334.4615,460.4861,333.1633,458.9628,332.1411,457.42,331.0915,455.7269,329.8299,455.8141,329.8879,456.2889,330.7294,457.0761,331.7785,457.6202,332.6661,458.1111,333.5183,458.8584,334.541,458.882,334.5764,457.9449,335.2104,456.8751,335.6447,455.9749,336.3342,455.0524,336.9903,454.1474,337.6725,454.1023,337.47,456.1104,337.425,457.9533,336.6391,459.9517,336.5505,461.8392,335.9645,463.76,335.5281"
                 style="stroke: #A80036; stroke-width: 1.0;"/><!--link Add a person to Add person's address-->
        <path d="M519,60.1831 L519.8642,60.1831 L519.2603,69.3429 L518.6932,78.5027 L519.9059,87.6625 L518.9731,96.8223 L519,105.9821 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0; stroke-dasharray: 7.0,7.0;"/>
        <polygon fill="#A80036"
                 points="519,111.2751,518.8053,111.1886,519.6752,109.4196,520.5774,107.6651,521.4813,105.9113,522.2558,104.0999,523,102.2751,522.8991,102.1742,522.1393,103.0144,521.2255,103.7007,520.7306,104.8057,519.6909,105.366,519,106.2751,518.9722,106.2473,518.1327,105.4078,517.5658,104.8409,516.4624,103.7376,515.8778,103.1529,515,102.2751,515.1159,102.3266,515.7495,104.0527,516.7696,105.9505,517.507,107.7227,518.2544,109.4993,519,111.2751"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="13" lengthAdjust="spacingAndGlyphs" textLength="61"
              x="477" y="90.27">«include»
        </text>
    </g>
</svg>
</div>

{% comment %}
@startuml
skinparam backgroundColor Ivory
skinparam handwritten true
left to right direction

title Person directory Use-Cases

actor Guest as guest
actor "Registered user" as user

guest <|-- user

usecase (Register)
usecase (Login)
usecase (Add a person)
usecase (Show all persons)
usecase (Update a person)
usecase (Delete a person)
usecase (Add person's address)

guest ---> (Register)
guest ---> (Login)
user ---> (Add a person)
user ---> (Show all persons)
user ---> (Update a person)
user ---> (Delete a person)
(Add a person) .> (Add person's address) : <<include>>

@enduml
{% endcomment %}
 

{: .note}
User in guest role can usually perform registration and login and optionally display public information.

Those Use-Cases are OK for high level understanding of the application scope, if you can't see what particular bubble
in that use case means, you can try [Sequence diagrams](https://en.wikipedia.org/wiki/Sequence_diagram). You should
also specify initial conditions for each Use-Case - e.g. "user has to be logged in", "there has to be record XY in the
database" etc. There can also be alternative scenarios for each Use-Case - e.g. add a person with or without an address.
Try also [Activity diagram](https://en.wikipedia.org/wiki/Activity_diagram) which is an extension of well-known
[flowchart](https://en.wikipedia.org/wiki/Flowchart?oldid=422892748) diagram which is taught in basic programming
courses.

{: .image-popup}
<div>
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
     contentScriptType="application/ecmascript" contentStyleType="text/css" height="569px" preserveAspectRatio="none"
     style="width:639px;height:569px;background:#FFFFF0;" version="1.1" viewBox="0 0 639 569" width="639px"
     zoomAndPan="magnify">
    <defs>
        <filter height="300%" id="f1k9bwn37ku558" width="300%" x="-1" y="-1">
            <feGaussianBlur result="blurOut" stdDeviation="2.0"/>
            <feColorMatrix in="blurOut" result="blurOut2" type="matrix"
                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 .4 0"/>
            <feOffset dx="4.0" dy="4.0" in="blurOut2" result="blurOut3"/>
            <feBlend in="SourceGraphic" in2="blurOut3" mode="normal"/>
        </filter>
    </defs>
    <g>
        <text fill="#000000" font-family="sans-serif" font-size="14" font-weight="bold" lengthAdjust="spacingAndGlyphs"
              textLength="324" x="158.5" y="22.9951">Store person with address into database
        </text>
        <path d="M27,116.5938 L27.12,116.5938 L27.8507,126.4747 L26.3077,136.3556 L26.2921,146.2365 L27.3325,156.1174 L27.624,165.9983 L27.7602,175.8792 L26.0964,185.7601 L27.093,195.641 L27.1247,205.522 L27.4097,215.4029 L27.8892,225.2838 L26.0014,235.1647 L26.2262,245.0456 L27.4612,254.9265 L26.1696,264.8074 L27.5319,274.6883 L27.6768,284.5693 L26.9396,294.4502 L27.3316,304.3311 L26.2559,314.212 L27.2688,324.0929 L27.818,333.9738 L26.5256,343.8547 L26.1367,353.7356 L27.5571,363.6166 L26.7609,373.4975 L27.002,383.3784 L27.9261,393.2593 L26.9451,403.1402 L27.6433,413.0211 L26.093,422.902 L26.3175,432.7829 L26.3734,442.6639 L27.1026,452.5448 L27.6344,462.4257 L26.5685,472.3066 L27,482.1875 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0; stroke-dasharray: 5.0,5.0;"/>
        <path d="M403.5,116.5938 L402.7094,116.5938 L404.4042,126.4747 L403.7007,136.3556 L404.3067,146.2365 L402.7233,156.1174 L403.3733,165.9983 L402.5422,175.8792 L402.6658,185.7601 L404.2757,195.641 L404.046,205.522 L402.5654,215.4029 L403.7728,225.2838 L404.0073,235.1647 L403.038,245.0456 L404.0828,254.9265 L402.9185,264.8074 L404.43,274.6883 L403.4046,284.5693 L404.3884,294.4502 L404.4903,304.3311 L402.8638,314.212 L403.9867,324.0929 L404.4772,333.9738 L403.9326,343.8547 L404.1476,353.7356 L402.8885,363.6166 L403.4269,373.4975 L403.6221,383.3784 L404.4673,393.2593 L403.8254,403.1402 L403.1013,413.0211 L402.6086,422.902 L403.5091,432.7829 L404.1109,442.6639 L403.9089,452.5448 L403.166,462.4257 L403.9338,472.3066 L403.5,482.1875 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0; stroke-dasharray: 5.0,5.0;"/>
        <path d="M597,116.5938 L596.0175,116.5938 L596.8651,126.4747 L596.0363,136.3556 L596.4055,146.2365 L597.649,156.1174 L596.657,165.9983 L597.6233,175.8792 L597.5745,185.7601 L597.3073,195.641 L596.7984,205.522 L596.1994,215.4029 L597.5253,225.2838 L596.6126,235.1647 L597.2899,245.0456 L596.4418,254.9265 L596.24,264.8074 L597.3538,274.6883 L596.4599,284.5693 L597.296,294.4502 L596.6169,304.3311 L596.2015,314.212 L596.8681,324.0929 L596.2894,333.9738 L597.4974,343.8547 L596.0053,353.7356 L596.2859,363.6166 L597.9788,373.4975 L596.0164,383.3784 L596.4293,393.2593 L596.8505,403.1402 L597.2116,413.0211 L596.3831,422.902 L597.6435,432.7829 L597.997,442.6639 L596.8189,452.5448 L597.4346,462.4257 L597.1958,472.3066 L597,482.1875 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0; stroke-dasharray: 5.0,5.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="32"
              x="8" y="113.292">User
        </text>
        <polygon fill="#FEFECE" filter="url(#f1k9bwn37ku558)"
                 points="34.6993,45.9254,33.8219,48.3434,31.9831,49.3624,30.9524,50.3175,28.6892,50.6415,26.719,51.2552,24.0384,50.9187,22.753,49.6726,21.598,48.7838,20.4022,47.8425,19.4291,46.1958,18.9119,44.1515,18.7786,42.5502,19.1371,41.0443,20.5493,38.7934,21.6828,37.9771,22.8,36.5989,25.0988,35.4365,27.5845,35.5194,29.5189,35.4425,31.7106,36.6794,32.5654,38.2108,34.2065,39.2737,34.4936,41.7711,35.2037,43.2928,34.4363,44.8021"
                 style="stroke: #A80036; stroke-width: 2.0;"/>
        <path d="M27,51.2969 L26.6889,51.2969 L26.5931,56.6969 L26.9508,62.0969 L27.4085,67.4969 L27.5114,72.8969 L27,78.2969 M14,59.2969 L14,59.7357 L19.2,58.9624 L24.4,59.175 L29.6,59.4121 L34.8,58.7761 L40,59.2969 M27,78.2969 L27.0905,78.3753 L24.8089,81.6512 L22.0025,84.4724 L18.9669,87.0949 L16.2629,90.0047 L14,93.2969 M27,78.2969 L27.4362,78.675 L29.2661,81.0075 L31.9896,84.1145 L34.5648,87.0931 L37.2539,90.1703 L40,93.2969 "
              fill="none" filter="url(#f1k9bwn37ku558)" style="stroke: #A80036; stroke-width: 2.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="32"
              x="8" y="494.1826">User
        </text>
        <polygon fill="#FEFECE" filter="url(#f1k9bwn37ku558)"
                 points="34.3536,509.9949,33.713,512.4383,31.931,514.3937,29.1742,515.1991,26.6558,515.5796,24.6493,515.4701,23.0738,514.9841,21.1401,513.4621,19.6304,511.6225,19.3978,509.6017,18.8302,507.3276,18.679,505.7734,19.7845,504.3048,21.3593,502.2142,22.8413,500.792,24.9553,499.4221,26.6632,499.3236,28.0491,500,30.4466,499.9302,32.2499,501.4318,33.4234,503.1107,34.8773,505.0409,35.3859,506.9705,34.9593,508.8369"
                 style="stroke: #A80036; stroke-width: 2.0;"/>
        <path d="M27,515.4844 L27.0653,515.4844 L27.0062,520.8844 L26.9796,526.2844 L27.6367,531.6844 L27.2458,537.0844 L27,542.4844 M14,523.4844 L14,523.6445 L19.2,524.1153 L24.4,524.11 L29.6,523.2973 L34.8,522.8989 L40,523.4844 M27,542.4844 L26.6485,542.1798 L24.0313,545.1648 L21.4349,548.168 L19.4599,551.7096 L16.9624,554.7985 L14,557.4844 M27,542.4844 L26.7853,542.2983 L29.2375,545.1702 L31.9159,548.2382 L34.9457,551.6107 L37.4304,554.5108 L40,557.4844 "
              fill="none" filter="url(#f1k9bwn37ku558)" style="stroke: #A80036; stroke-width: 2.0;"/>
        <polygon fill="#FEFECE" filter="url(#f1k9bwn37ku558)"
                 points="346.5,81.2969,346.5,81.4801,356.5909,80.5666,366.6818,81.916,376.7727,80.9652,386.8636,81.4952,396.9545,81.137,407.0455,81.1166,417.1364,81.9342,427.2273,81.5503,437.3182,81.6001,447.4091,80.9095,457.5,81.2969,457.4902,81.2969,457.6387,87.3563,457.3845,93.4156,457.6979,99.475,457.6348,105.5344,457.5,111.5938,457.5,111.651,447.4091,111.8576,437.3182,111.4536,427.2273,111.8807,417.1364,112.1574,407.0455,111.9322,396.9545,111.2089,386.8636,111.9636,376.7727,111.6851,366.6818,110.9947,356.5909,111.0314,346.5,111.5938,346.4574,111.5938,346.5941,105.5344,346.5353,99.475,346.2866,93.4156,346.2841,87.3563,346.5,81.2969"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="97"
              x="353.5" y="101.292">My application
        </text>
        <polygon fill="#FEFECE" filter="url(#f1k9bwn37ku558)"
                 points="346.5,481.1875,346.5,480.887,356.5909,481.4912,366.6818,480.4726,376.7727,481.858,386.8636,481.4406,396.9545,480.9434,407.0455,481.259,417.1364,480.819,427.2273,481.3139,437.3182,481.3796,447.4091,481.0762,457.5,481.1875,457.6035,481.1875,457.3786,487.2469,457.3414,493.3063,457.7227,499.3656,457.6744,505.425,457.5,511.4844,457.5,511.0842,447.4091,511.9701,437.3182,512.1304,427.2273,510.9527,417.1364,512.112,407.0455,511.7268,396.9545,511.6079,386.8636,511.176,376.7727,510.7628,366.6818,511.6134,356.5909,511.1354,346.5,511.4844,346.4127,511.4844,346.4303,505.425,346.7013,499.3656,346.4583,493.3063,346.7136,487.2469,346.5,481.1875"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="97"
              x="353.5" y="501.1826">My application
        </text>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="66"
              x="561" y="113.292">Database
        </text>
        <path d="M579,64.2969 C579,54.2969 597,54.2969 597,54.2969 C597,54.2969 615,54.2969 615,64.2969 L615,90.2969 C615,100.2969 597,100.2969 597,100.2969 C597,100.2969 579,100.2969 579,90.2969 L579,64.2969 "
              fill="#FEFECE" filter="url(#f1k9bwn37ku558)" style="stroke: #000000; stroke-width: 1.5;"/>
        <path d="M579,64.2969 C579,74.2969 597,74.2969 597,74.2969 C597,74.2969 615,74.2969 615,64.2969 " fill="none"
              style="stroke: #000000; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="14" lengthAdjust="spacingAndGlyphs" textLength="66"
              x="561" y="494.1826">Database
        </text>
        <path d="M579,507.4844 C579,497.4844 597,497.4844 597,497.4844 C597,497.4844 615,497.4844 615,507.4844 L615,533.4844 C615,543.4844 597,543.4844 597,543.4844 C597,543.4844 579,543.4844 579,533.4844 L579,507.4844 "
              fill="#FEFECE" filter="url(#f1k9bwn37ku558)" style="stroke: #000000; stroke-width: 1.5;"/>
        <path d="M579,507.4844 C579,517.4844 597,517.4844 597,517.4844 C597,517.4844 615,517.4844 615,507.4844 "
              fill="none" style="stroke: #000000; stroke-width: 1.5;"/>
        <polygon fill="#A80036"
                 points="392,143.7266,391.9414,143.5802,394.0341,144.6119,396.0337,145.4108,397.9089,145.8989,399.9287,146.7483,402,147.7266,401.9938,147.7111,399.993,148.5089,398.0571,149.4694,396.0134,150.1601,393.9459,150.7912,392,151.7266,392.1214,151.848,392.9241,151.0506,393.5708,150.0973,394.5457,149.4722,395.3343,148.6609,396,147.7266,396.1244,147.8509,395.0832,146.8098,394.2406,145.9671,393.4331,145.1597,392.6301,144.3567,392,143.7266"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M27,147.7266 L27,146.8384 L37.027,148.4173 L47.0541,147.4636 L57.0811,147.6843 L67.1081,147.9993 L77.1351,148.0275 L87.1622,146.8429 L97.1892,147.4474 L107.2162,148.0301 L117.2432,148.6962 L127.2703,147.1761 L137.2973,148.2034 L147.3243,146.9552 L157.3514,147.6302 L167.3784,147.2529 L177.4054,148.5662 L187.4324,147.7687 L197.4595,147.7543 L207.4865,147.1183 L217.5135,147.9927 L227.5405,147.4984 L237.5676,147.049 L247.5946,147.6129 L257.6216,147.5876 L267.6486,146.8761 L277.6757,148.23 L287.7027,148.7158 L297.7297,146.9298 L307.7568,147.095 L317.7838,148.2609 L327.8108,147.9049 L337.8378,146.9185 L347.8649,147.5893 L357.8919,148.5644 L367.9189,146.9218 L377.9459,148.4798 L387.973,147.1582 L398,147.7266 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="13" lengthAdjust="spacingAndGlyphs" textLength="187"
              x="34" y="142.6606">Click the "Add person button"
        </text>
        <polygon fill="#A80036"
                 points="38,172.8594,38.0817,173.0635,36.0655,173.8232,34.0488,174.5815,32.0329,175.3416,30.0046,176.0708,28,176.8594,27.944,176.7194,29.941,177.5118,31.9453,178.3226,33.9486,179.131,35.9096,179.8335,38,180.8594,37.9374,180.7968,37.3622,180.2215,36.4542,179.3136,35.5776,178.437,34.9717,177.8311,34,176.8594,33.8297,176.689,34.685,175.9444,35.5775,175.2369,36.5525,174.6118,37.1432,173.6025,38,172.8594"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M32,176.8594 L32,176.217 L42.027,176.407 L52.0541,176.4 L62.0811,177.2056 L72.1081,176.5518 L82.1351,176.403 L92.1622,176.6285 L102.1892,176.07 L112.2162,177.2209 L122.2432,177.1337 L132.2703,176.9396 L142.2973,177.4589 L152.3243,177.3966 L162.3514,176.6331 L172.3784,177.3537 L182.4054,177.768 L192.4324,177.0484 L202.4595,177.265 L212.4865,176.9107 L222.5135,177.5646 L232.5405,176.5313 L242.5676,176.4181 L252.5946,175.9867 L262.6216,176.3563 L272.6486,177.5956 L282.6757,176.7371 L292.7027,177.4657 L302.7297,176.1368 L312.7568,176.3456 L322.7838,177.7964 L332.8108,177.3601 L342.8378,176.3958 L352.8649,176.172 L362.8919,177.4192 L372.9189,177.4442 L382.9459,176.7941 L392.973,176.6182 L403,176.8594 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0; stroke-dasharray: 2.0,2.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="13" lengthAdjust="spacingAndGlyphs" textLength="283"
              x="44" y="171.7935">Display form with person and address inputs
        </text>
        <polygon fill="#A80036"
                 points="392,201.9922,392.0201,202.0425,393.9079,202.5619,395.9347,203.4291,397.968,204.3121,399.9172,204.9851,402,205.9922,401.9718,205.9218,400.0894,207.0158,397.9686,207.5138,395.9667,208.309,393.966,209.1073,392,209.9922,392.1529,210.145,392.9101,209.3023,393.4347,208.2269,394.5454,207.7376,395.1926,206.7848,396,205.9922,395.9626,205.9548,395.1977,205.1899,394.5564,204.5486,393.7496,203.7418,392.6465,202.6387,392,201.9922"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M27,205.9922 L27,206.444 L37.027,206.8541 L47.0541,205.5527 L57.0811,206.4925 L67.1081,206.0717 L77.1351,206.7752 L87.1622,205.5375 L97.1892,205.3659 L107.2162,206.5791 L117.2432,205.0473 L127.2703,205.9043 L137.2973,206.4071 L147.3243,206.7219 L157.3514,206.6185 L167.3784,205.9624 L177.4054,205.8806 L187.4324,205.3743 L197.4595,205.2066 L207.4865,206.9278 L217.5135,206.3129 L227.5405,206.0663 L237.5676,206.6656 L247.5946,205.5376 L257.6216,205.5218 L267.6486,205.8447 L277.6757,205.7812 L287.7027,205.059 L297.7297,205.328 L307.7568,206.8072 L317.7838,205.437 L327.8108,206.8843 L337.8378,206.8819 L347.8649,206.0769 L357.8919,205.1885 L367.9189,206.5431 L377.9459,205.6033 L387.973,205.3443 L398,205.9922 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="13" lengthAdjust="spacingAndGlyphs" textLength="151"
              x="34" y="200.9263">Fill the form and submit
        </text>
        <path d="M312,218.9922 L311.878,218.9922 L311.6961,226.9922 L311.4888,234.9922 L312.27,242.9922 L311.5653,250.9922 L312,258.9922 L312,260.8343 L322,257.757 L332,259.5891 L342,260.1684 L352,258.9303 L362,259.9798 L372,260.9729 L382,258.5943 L392,258.5466 L402,258.3461 L412,257.734 L422,258.3865 L432,260.5094 L442,257.7749 L452,260.3181 L462,259.9202 L472,257.9544 L482,257.95 L492,258.9922 L491.4335,258.9922 L492.5158,252.9922 L491.5719,246.9922 L492.148,240.9922 L491.4081,234.9922 L492,228.9922 L492.135,229.1272 L489.9462,226.9384 L487.8389,224.831 L485.8586,222.8508 L484.0944,221.0866 L482,218.9922 L482,219.3914 L472,219.7467 L462,219.5619 L452,220.7177 L442,220.4261 L432,217.9276 L422,218.0707 L412,217.7224 L402,218.2132 L392,219.2826 L382,219.366 L372,217.7527 L362,220.4334 L352,220.8191 L342,218.9085 L332,219.5666 L322,219.7069 L312,218.9922 "
              fill="#FBFB77" filter="url(#f1k9bwn37ku558)" style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M482,218.9922 L481.9003,218.9922 L481.8919,220.9922 L482.5597,222.9922 L482.1329,224.9922 L481.8682,226.9922 L482,228.9922 L482,228.4402 L484,229.1857 L486,229.1253 L488,229.5831 L490,228.7395 L492,228.9922 L492.4611,229.4533 L489.5516,226.5438 L487.8924,224.8846 L486.1431,223.1353 L484.4283,221.4205 L482,218.9922 "
              fill="#FBFB77" style="stroke: #A80036; stroke-width: 1.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="13" lengthAdjust="spacingAndGlyphs" textLength="159"
              x="318" y="236.0591">Check whether user filled
        </text>
        <text fill="#000000" font-family="sans-serif" font-size="13" lengthAdjust="spacingAndGlyphs" textLength="135"
              x="318" y="251.1919">all mandatory inputs.
        </text>
        <polygon fill="#A80036"
                 points="585,285.3906,585.0294,285.4641,587.0644,286.3517,589.0716,287.1696,591.0769,287.9829,592.9922,288.5711,595,289.3906,594.9171,289.1834,593.0637,290.3499,590.9723,290.9214,589.0904,292.0167,586.9296,292.4147,585,293.3906,584.866,293.2566,585.6822,292.4728,586.528,291.7186,587.3382,290.9288,588.1081,290.0988,589,289.3906,588.8516,289.2422,588.0764,288.4671,587.4119,287.8025,586.7228,287.1134,585.7933,286.184,585,285.3906"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M404,289.3906 L404,288.6576 L413.8421,289.9959 L423.6842,289.4885 L433.5263,289.7708 L443.3684,288.9324 L453.2105,289.8104 L463.0526,290.2437 L472.8947,290.1295 L482.7368,289.1316 L492.5789,288.9329 L502.4211,288.81 L512.2632,290.0753 L522.1053,289.0393 L531.9474,289.9703 L541.7895,290.3523 L551.6316,290.0188 L561.4737,288.6328 L571.3158,289.8026 L581.1579,288.6971 L591,289.3906 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="13" lengthAdjust="spacingAndGlyphs" textLength="160"
              x="411" y="284.3247">Store the address record
        </text>
        <polygon fill="#A80036"
                 points="415,314.5234,414.9887,314.4952,412.9616,315.2275,410.99,316.0984,408.9624,316.8294,407.0651,317.8862,405,318.5234,405.0871,318.7412,406.9876,319.2925,408.9436,319.9824,410.9357,320.7628,413.02,321.7734,415,322.5234,415.102,322.6255,414.1216,321.645,413.4018,320.9252,412.737,320.2604,411.9232,319.4467,411,318.5234,410.9382,318.4616,411.6956,317.6191,412.443,316.7664,413.3771,316.1005,414.2194,315.3428,415,314.5234"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M409,318.5234 L409,318.1305 L418.8421,318.2792 L428.6842,319.2142 L438.5263,319.2468 L448.3684,319.4504 L458.2105,317.7324 L468.0526,319.0718 L477.8947,318.81 L487.7368,318.1518 L497.5789,318.8011 L507.4211,319.2364 L517.2632,318.0429 L527.1053,318.9988 L536.9474,318.1345 L546.7895,317.9161 L556.6316,319.0339 L566.4737,318.4064 L576.3158,318.1654 L586.1579,317.8409 L596,318.5234 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0; stroke-dasharray: 2.0,2.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="13" lengthAdjust="spacingAndGlyphs" textLength="168"
              x="421" y="313.4575">Confirm storage (no error)
        </text>
        <polygon fill="#A80036"
                 points="585,343.6563,584.9119,343.4361,587.0587,344.6031,588.9492,345.1293,591.0602,346.2067,592.9332,346.6892,595,347.6563,594.9878,347.6256,592.9403,348.307,591.0642,349.4167,588.9093,349.8296,587.0221,350.9116,585,351.6563,584.8544,351.5106,585.6287,350.6849,586.4508,349.9071,587.3372,349.1934,588.2621,348.5183,589,347.6563,589.0422,347.6984,588.05,346.7063,587.4138,346.0701,586.4374,345.0937,585.8596,344.5158,585,343.6563"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M404,347.6563 L404,347.4441 L413.8421,348.1583 L423.6842,347.3647 L433.5263,347.2621 L443.3684,348.3681 L453.2105,348.2919 L463.0526,348.1836 L472.8947,346.87 L482.7368,346.8868 L492.5789,347.4971 L502.4211,347.7092 L512.2632,348.1136 L522.1053,346.9641 L531.9474,347.7452 L541.7895,348.3114 L551.6316,346.7949 L561.4737,347.9441 L571.3158,347.8605 L581.1579,347.8454 L591,347.6563 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="13" lengthAdjust="spacingAndGlyphs" textLength="169"
              x="411" y="342.5903">Request ID of new address
        </text>
        <polygon fill="#A80036"
                 points="415,372.7891,414.9816,372.7431,412.9397,373.4384,411.0218,374.4434,409.0907,375.4158,406.9229,375.7962,405,376.7891,405.0117,376.8182,406.9896,377.5631,408.9185,378.1853,410.9236,378.9981,413.0225,380.0453,415,380.7891,414.9141,380.7032,414.1516,379.9407,413.3141,379.1032,412.7588,378.5479,411.81,377.599,411,376.7891,410.8362,376.6253,411.7108,375.8999,412.5566,375.1457,413.3699,374.359,414.0801,373.4691,415,372.7891"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M409,376.7891 L409,376.2698 L418.8421,377.4196 L428.6842,377.5872 L438.5263,377.3959 L448.3684,377.6467 L458.2105,376.3872 L468.0526,376.11 L477.8947,376.599 L487.7368,377.6433 L497.5789,375.8826 L507.4211,376.8355 L517.2632,377.2747 L527.1053,376.9256 L536.9474,376.4596 L546.7895,377.5755 L556.6316,377.4542 L566.4737,376.0525 L576.3158,377.7131 L586.1579,377.5874 L596,376.7891 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0; stroke-dasharray: 2.0,2.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="13" lengthAdjust="spacingAndGlyphs" textLength="59"
              x="421" y="371.7231">Return ID
        </text>
        <polygon fill="#A80036"
                 points="585,401.9219,585.0349,402.0091,587.0592,402.87,589.0908,403.7488,591.0865,404.5381,593.0744,405.3078,595,405.9219,594.9617,405.826,592.9742,406.6574,590.959,407.4195,589.0012,408.3249,586.9667,409.0387,585,409.9219,585.1273,410.0492,585.6443,408.9662,586.63,408.3519,587.569,407.6909,588.2659,406.7878,589,405.9219,589.0782,406,588.1909,405.1128,587.2457,404.1676,586.6947,403.6166,585.7649,402.6868,585,401.9219"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M404,405.9219 L404,405.7369 L413.8421,406.3274 L423.6842,406.2562 L433.5263,406.7799 L443.3684,406.4206 L453.2105,406.4144 L463.0526,406.3154 L472.8947,406.2407 L482.7368,406.6605 L492.5789,405.6535 L502.4211,406.0554 L512.2632,406.1359 L522.1053,404.9238 L531.9474,405.4846 L541.7895,406.0481 L551.6316,405.1608 L561.4737,405.3819 L571.3158,405.5311 L581.1579,406.7332 L591,405.9219 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="13" lengthAdjust="spacingAndGlyphs" textLength="153"
              x="411" y="400.856">Store the person record
        </text>
        <polygon fill="#A80036"
                 points="415,431.0547,415.0523,431.1853,412.9086,431.6261,410.9724,432.5858,409.0092,433.4778,406.9925,434.2359,405,435.0547,404.9652,434.9677,407.0485,435.976,408.9592,436.5527,410.9652,437.3676,413.0517,438.384,415,439.0547,415.0589,439.1136,414.2007,438.2554,413.3063,437.361,412.695,436.7496,411.7232,435.7779,411,435.0547,411.0529,435.1076,411.8202,434.2749,412.6028,433.4575,413.3384,432.5931,414.2476,431.9023,415,431.0547"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M409,435.0547 L409,435.8589 L418.8421,436.0307 L428.6842,434.7207 L438.5263,434.4722 L448.3684,435.8555 L458.2105,434.902 L468.0526,434.9277 L477.8947,435.1381 L487.7368,435.9969 L497.5789,435.2263 L507.4211,434.342 L517.2632,435.5029 L527.1053,435.289 L536.9474,434.7216 L546.7895,435.8379 L556.6316,434.5724 L566.4737,435.3173 L576.3158,434.3555 L586.1579,435.2192 L596,435.0547 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0; stroke-dasharray: 2.0,2.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="13" lengthAdjust="spacingAndGlyphs" textLength="168"
              x="421" y="429.9888">Confirm storage (no error)
        </text>
        <polygon fill="#A80036"
                 points="38,460.1875,38.083,460.3949,35.9595,460.8862,33.9875,461.7563,32.0854,462.8009,30.0694,463.5609,28,464.1875,28.081,464.39,30.0346,465.0741,32.0118,465.817,33.9961,466.5777,36.0351,467.4753,38,468.1875,38.0634,468.2509,37.0542,467.2417,36.551,466.7385,35.5607,465.7482,34.9543,465.1418,34,464.1875,33.923,464.1105,34.6983,463.2858,35.4238,462.4113,36.5041,461.8916,37.048,460.8355,38,460.1875"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M32,464.1875 L32,464.4019 L42.027,464.2235 L52.0541,464.2136 L62.0811,463.7769 L72.1081,463.6105 L82.1351,464.3653 L92.1622,464.5857 L102.1892,464.1621 L112.2162,464.1402 L122.2432,464.7531 L132.2703,464.2458 L142.2973,463.6392 L152.3243,464.5079 L162.3514,464.7309 L172.3784,465.0747 L182.4054,463.3146 L192.4324,463.6488 L202.4595,464.9862 L212.4865,463.4972 L222.5135,464.4475 L232.5405,463.6778 L242.5676,464.0651 L252.5946,464.0668 L262.6216,463.8859 L272.6486,464.663 L282.6757,464.0384 L292.7027,463.7645 L302.7297,463.7513 L312.7568,463.3807 L322.7838,463.6844 L332.8108,464.2941 L342.8378,464.9434 L352.8649,463.8832 L362.8919,463.5783 L372.9189,463.7346 L382.9459,465.0393 L392.973,463.5009 L403,464.1875 "
              fill="none" style="stroke: #A80036; stroke-width: 1.0; stroke-dasharray: 2.0,2.0;"/>
        <text fill="#000000" font-family="sans-serif" font-size="13" lengthAdjust="spacingAndGlyphs" textLength="353"
              x="44" y="459.1216">Display confirmation and redirect user to list of persons
        </text>
    </g>
</svg>
</div>

{% comment %}
@startuml
skinparam backgroundColor Ivory
skinparam handwritten true

title Store person with address into database

actor User as user
participant "My application" as app
database "Database" as db

user -> app: Click the "Add person button"
user <-- app: Display form with person and address inputs

user -> app: Fill the form and submit
note over app
    Check whether user filled
    all mandatory inputs.
end note
app -> db: Store the address record
app <-- db: Confirm storage (no error)
app -> db: Request ID of new address
app <-- db: Return ID
app -> db: Store the person record
app <-- db: Confirm storage (no error)
user <-- app: Display confirmation and redirect user to list of persons

@enduml  
{% endcomment %}

Sometimes you can choose between more suitable UML diagrams, here is the same process (just the important part of it)
modelled with Activity diagram:

{: .image-popup}
<div>
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
     contentScriptType="application/ecmascript" contentStyleType="text/css" height="489px" preserveAspectRatio="none"
     style="width:581px;height:489px;background:#FFFFF0;" version="1.1" viewBox="0 0 581 489" width="581px"
     zoomAndPan="magnify">
    <defs>
        <filter height="300%" id="fke4gdczpf8i3" width="300%" x="-1" y="-1">
            <feGaussianBlur result="blurOut" stdDeviation="2.0"/>
            <feColorMatrix in="blurOut" result="blurOut2" type="matrix"
                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 .4 0"/>
            <feOffset dx="4.0" dy="4.0" in="blurOut2" result="blurOut3"/>
            <feBlend in="SourceGraphic" in2="blurOut3" mode="normal"/>
        </filter>
    </defs>
    <g>
        <text fill="#000000" font-family="sans-serif" font-size="18" lengthAdjust="spacingAndGlyphs" textLength="356"
              x="111.75" y="26.708">Store person with address into database
        </text>
        <polygon fill="#000000" filter="url(#fke4gdczpf8i3)"
                 points="288.4722,43.6364,286.884,45.9096,286.0333,48.6772,283.7291,50.3306,280.9999,50.493,278.3814,51.3408,275.2346,49.7672,271.7591,48.8237,270.3327,45.7408,269.164,43.2566,268.1917,39.9515,269.1684,36.9425,270.6931,35.6705,272.2596,33.5761,274.2252,32.0061,276.8183,31.2175,280.2428,30.6818,281.9517,32.0472,285.2853,33.0222,287.4267,34.8649,287.6927,37.2227,288.1149,38.8761,288.7701,41.0981"
                 style="stroke: none; stroke-width: 1.0;"/>
        <polygon fill="#FEFECE" filter="url(#fke4gdczpf8i3)"
                 points="197.75,70.9531,197.75,70.4572,207.875,70.646,218,71.3696,228.125,71.683,238.25,70.8786,248.375,71.3815,258.5,70.8457,268.625,70.7759,278.75,70.7092,288.875,70.4669,299,71.1345,309.125,70.8072,319.25,71.5504,329.375,70.3722,339.5,70.6069,349.625,71.3932,359.75,70.9531,359.8534,71.0565,362.2754,73.4785,364.4293,75.6325,366.9942,78.1973,369.275,80.4781,371.75,82.9531,371.6213,82.8245,369.4352,85.4383,366.9886,87.7917,364.7193,90.3225,362.1166,92.5197,359.75,94.9531,359.75,95.5454,349.625,94.9894,339.5,94.8607,329.375,95.2288,319.25,94.9892,309.125,94.7747,299,95.3053,288.875,94.4451,278.75,94.6653,268.625,95.5891,258.5,95.2542,248.375,94.9285,238.25,94.3528,228.125,94.9742,218,95.6735,207.875,94.9222,197.75,94.9531,197.6959,94.899,195.2971,92.5002,192.8667,90.0698,190.6767,87.8799,188.16,85.3631,185.75,82.9531,185.7033,82.9064,188.2256,80.6287,190.4252,78.0283,193.0982,75.9013,195.174,73.1772,197.75,70.9531"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="11" lengthAdjust="spacingAndGlyphs" textLength="162"
              x="197.75" y="86.7612">User filled all required fields
        </text>
        <text fill="#000000" font-family="sans-serif" font-size="11" lengthAdjust="spacingAndGlyphs" textLength="20"
              x="165.75" y="80.3589">yes
        </text>
        <text fill="#000000" font-family="sans-serif" font-size="11" lengthAdjust="spacingAndGlyphs" textLength="14"
              x="371.75" y="80.3589">no
        </text>
        <polygon fill="#FEFECE" filter="url(#fke4gdczpf8i3)"
                 points="41.5,153.3555,41.5,153.1759,51.2778,153.8637,61.0556,152.6756,70.8333,153.1006,80.6111,153.3077,90.3889,153.2333,100.1667,154.0525,109.9444,153.9247,119.7222,153.3944,129.5,153.4483,139.2778,154.0339,149.0556,153.6084,158.8333,152.7978,168.6111,153.2539,178.3889,153.2855,188.1667,153.7269,197.9444,153.0399,207.7222,153.4756,217.5,153.3555,217.5929,153.5798,219.3098,154.1893,221.0861,154.942,222.8039,155.5535,224.5509,156.2357,226.3388,157.0166,226.2825,156.9933,227.072,158.7848,227.7797,160.5424,228.3873,162.2585,229.3714,164.1306,230,165.8555,230.1904,165.8555,230.0176,167.6492,230.101,169.443,229.8715,171.2367,230.196,173.0305,230,174.8242,230.0995,174.8654,229.4449,176.6654,228.4734,178.334,227.6817,180.0772,227.0967,181.9059,226.3388,183.6631,226.3389,183.6633,224.5905,184.4423,222.764,185.0327,220.9742,185.7117,219.2564,186.5647,217.5,187.3242,217.5,187.8095,207.7222,186.7769,197.9444,186.7348,188.1667,186.8999,178.3889,187.5625,168.6111,186.8559,158.8333,186.6444,149.0556,187.6478,139.2778,187.9216,129.5,187.8304,119.7222,186.5813,109.9444,187.3904,100.1667,186.9222,90.3889,186.7007,80.6111,187.0952,70.8333,187.25,61.0556,187.3467,51.2778,187.3322,41.5,187.3242,41.5375,187.4147,39.6586,186.4143,37.8896,185.679,36.1125,184.9243,34.4744,184.5051,32.6612,183.6631,32.5042,183.598,32.0063,181.9273,31.3442,180.1886,30.3366,178.3068,29.7255,176.5892,29,174.8242,28.7639,174.8242,28.9702,173.0305,29.0302,171.2367,28.7652,169.443,29.0547,167.6492,29,165.8555,28.8523,165.7943,29.749,164.0946,30.5805,162.368,31.4142,160.6423,31.8957,158.7706,32.6612,157.0166,32.715,157.1466,34.3399,156.0695,36.2638,155.7143,37.8959,154.6543,39.76,154.1548,41.5,153.3555"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="12" lengthAdjust="spacingAndGlyphs" textLength="181"
              x="39" y="174.4941">Store address into database
        </text>
        <polygon fill="#FEFECE" filter="url(#fke4gdczpf8i3)"
                 points="28,222.3242,28,222.9321,38.15,221.8616,48.3,221.8641,58.45,221.8346,68.6,221.928,78.75,221.9808,88.9,222.2948,99.05,222.8761,109.2,222.718,119.35,221.8362,129.5,222.6398,139.65,222.8839,149.8,223.0489,159.95,222.1784,170.1,221.6559,180.25,221.8142,190.4,221.6462,200.55,222.2492,210.7,222.1183,220.85,221.8347,231,222.3242,230.9954,222.3132,232.806,223.1487,234.5068,223.7192,236.2613,224.4195,238.1642,225.478,239.8388,225.9854,240.0473,226.0717,240.3845,227.6759,241.1573,229.4604,242.2223,231.3661,242.6956,233.0265,243.5,234.8242,243.4355,234.8242,243.3916,236.618,243.4931,238.4117,243.425,240.2055,243.5735,241.9992,243.5,243.793,243.6005,243.8346,242.5971,245.49,242.2211,247.4054,241.201,249.0539,240.6107,250.8805,239.8388,252.6318,239.8864,252.7466,238.0805,253.3868,236.2314,253.9226,234.5426,254.8455,232.7929,255.6213,231,256.293,231,256.8768,220.85,256.923,210.7,256.4522,200.55,256.9018,190.4,255.948,180.25,256.9958,170.1,256.7757,159.95,255.7841,149.8,255.6204,139.65,255.7886,129.5,256.6209,119.35,255.5684,109.2,256.1662,99.05,255.6511,88.9,256.2708,78.75,256.0712,68.6,256.9207,58.45,256.5686,48.3,255.5747,38.15,256.3126,28,256.293,28.0277,256.3598,26.2475,255.5975,24.5036,254.9231,22.6431,253.9669,21.0137,253.5688,19.1612,252.6318,19.2068,252.6507,18.2732,250.7995,17.8985,249.1799,16.8908,247.298,16.303,245.5901,15.5,243.793,15.647,243.793,15.3907,241.9992,15.3914,240.2055,15.3093,238.4117,15.3627,236.618,15.5,234.8242,15.5282,234.8359,16.4196,233.1341,16.8379,231.2363,17.5958,229.4791,18.5478,227.8024,19.1612,225.9854,19.0713,225.7684,20.8523,225.0682,22.6789,224.4778,24.4124,223.663,26.1497,222.8573,28,222.3242"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="12" lengthAdjust="spacingAndGlyphs" textLength="208"
              x="25.5" y="243.4629">Obtain address ID from database
        </text>
        <polygon fill="#FEFECE" filter="url(#fke4gdczpf8i3)"
                 points="57.5,104.9531,57.5,104.9858,67.7857,105.4371,78.0714,104.3131,88.3571,104.8846,98.6429,104.4439,108.9286,104.2053,119.2143,104.9523,129.5,105.1584,139.7857,105.5072,150.0714,104.6689,160.3571,105.1311,170.6429,105.0401,180.9286,105.3489,191.2143,105.59,201.5,104.9531,201.6617,105.1148,204.0323,107.4854,206.1541,109.6072,208.6333,112.0864,211.0946,114.5477,213.5,116.9531,213.3281,116.7812,211.0689,119.322,208.7974,121.8505,206.2093,124.0624,203.8805,126.5336,201.5,128.9531,201.5,128.9054,191.2143,129.2426,180.9286,129.1678,170.6429,128.6274,160.3571,129.4975,150.0714,128.4821,139.7857,128.4753,129.5,129.1023,119.2143,128.4095,108.9286,128.3056,98.6429,129.3748,88.3571,128.9216,78.0714,128.226,67.7857,129.6316,57.5,128.9531,57.3463,128.7995,54.9383,126.3915,52.6355,124.0886,50.2733,121.7265,47.9908,119.4439,45.5,116.9531,45.4235,116.8767,48.0302,114.6833,50.1912,112.0444,52.8631,109.9162,55.1572,107.4103,57.5,104.9531"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="11" lengthAdjust="spacingAndGlyphs" textLength="20"
              x="133.5" y="139.1636">yes
        </text>
        <text fill="#000000" font-family="sans-serif" font-size="11" lengthAdjust="spacingAndGlyphs" textLength="144"
              x="57.5" y="120.7612">User filled address fields
        </text>
        <text fill="#000000" font-family="sans-serif" font-size="11" lengthAdjust="spacingAndGlyphs" textLength="14"
              x="213.5" y="114.3589">no
        </text>
        <polygon fill="#FEFECE" filter="url(#fke4gdczpf8i3)"
                 points="129.5,276.293,129.5953,276.3883,131.7446,278.5375,134.2616,281.0546,136.8672,283.6602,139.173,285.9659,141.5,288.293,141.5102,288.3032,139.1374,290.7303,136.5414,292.9344,134.2811,295.4741,131.9705,297.9635,129.5,300.293,129.345,300.1379,127.0513,297.8442,124.6686,295.4616,122.1378,292.9307,119.8102,290.6031,117.5,288.293,117.5076,288.3006,119.7691,285.762,122.2666,283.4596,124.6318,281.0247,127.0048,278.5978,129.5,276.293"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="#FEFECE" filter="url(#fke4gdczpf8i3)"
                 points="22.5,320.293,22.5,320.3754,32.6905,320.2684,42.881,320.3033,53.0714,319.5629,63.2619,320.4081,73.4524,320.5423,83.6429,320.1726,93.8333,320.3413,104.0238,320.5563,114.2143,319.5678,124.4048,319.7375,134.5952,319.7197,144.7857,320.2368,154.9762,320.6956,165.1667,320.6337,175.3571,320.216,185.5476,320.873,195.7381,320.2096,205.9286,319.7936,216.119,319.7251,226.3095,319.7459,236.5,320.293,236.4688,320.2177,238.179,320.8109,239.9592,321.5731,241.8464,322.5938,243.611,323.3184,245.3388,323.9541,245.56,324.0458,246.1946,325.7731,247.0193,327.5792,247.6079,329.2874,248.2454,331.0159,249,332.793,248.985,332.793,249.1947,334.5867,248.8165,336.3805,248.8077,338.1742,248.8323,339.968,249,341.7617,249.1527,341.825,248.1053,343.4622,247.5517,345.304,246.9596,347.1298,245.9626,348.7879,245.3388,350.6006,245.3695,350.6745,243.6533,351.5313,241.7131,351.8472,240.1246,353.0123,238.1953,353.3546,236.5,354.2617,236.5,354.2883,226.3095,354.7317,216.119,354.1157,205.9286,353.6427,195.7381,354.2741,185.5476,353.791,175.3571,353.9377,165.1667,354.5229,154.9762,353.5619,144.7857,354.6162,134.5952,354.0121,124.4048,353.5669,114.2143,353.8996,104.0238,353.5579,93.8333,354.8188,83.6429,354.0507,73.4524,354.3894,63.2619,353.5713,53.0714,354.0989,42.881,353.7535,32.6905,353.882,22.5,354.2617,22.4728,354.1961,20.6789,353.4007,19.0586,353.0246,17.2371,352.1625,15.4977,351.4987,13.6612,350.6006,13.6294,350.5874,13.0821,348.8962,12.0218,346.9926,11.5885,345.3486,10.7226,343.5255,10,341.7617,10.1081,341.7617,10.0326,339.968,10.2297,338.1742,10.0515,336.3805,9.9004,334.5867,10,332.793,9.8685,332.7385,10.7643,331.0385,11.5671,329.3,12.0588,327.4325,12.8716,325.6981,13.6612,323.9541,13.7153,324.0848,15.4446,323.2598,17.1184,322.3006,18.9006,321.6031,20.801,321.1913,22.5,320.293"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="12" lengthAdjust="spacingAndGlyphs" textLength="219"
              x="20" y="341.4316">Store person record into database
        </text>
        <polygon fill="#FEFECE" filter="url(#fke4gdczpf8i3)"
                 points="46.5,374.2617,46.5,373.59,56.2647,374.4034,66.0294,375.0088,75.7941,373.7799,85.5588,374.8721,95.3235,373.6598,105.0882,373.7235,114.8529,373.8578,124.6176,373.5553,134.3824,374.4007,144.1471,374.2997,153.9118,373.6968,163.6765,374.7541,173.4412,374.5155,183.2059,374.2831,192.9706,373.9156,202.7353,374.5968,212.5,374.2617,212.5501,374.3827,214.301,375.0742,216.033,375.7201,217.8646,376.6064,219.5952,377.2489,221.3388,377.9229,221.3733,377.9372,222.2059,379.7465,222.7632,381.4418,223.7532,383.3163,224.2238,384.9758,225,386.7617,225.0787,386.7617,225.0793,388.5555,224.757,390.3492,225.0581,392.143,224.9992,393.9367,225,395.7305,225.0944,395.7696,224.2969,397.5103,223.3053,399.1706,222.8411,401.0494,222.1701,402.8426,221.3388,404.5693,221.251,404.3573,219.5695,405.2977,217.7986,406.0225,216.0548,406.8125,214.293,407.5592,212.5,408.2305,212.5,408.3231,202.7353,408.2748,192.9706,408.7857,183.2059,408.1909,173.4412,408.1922,163.6765,408.5854,153.9118,408.6837,144.1471,408.2797,134.3824,408.4171,124.6176,408.4379,114.8529,407.7903,105.0882,408.1926,95.3235,407.5048,85.5588,408.57,75.7941,407.8657,66.0294,408.2112,56.2647,408.0721,46.5,408.2305,46.4144,408.0238,44.7063,407.4357,42.9904,406.8287,41.2428,406.145,39.4253,405.2928,37.6612,404.5693,37.7748,404.6164,37.1197,402.8806,36.3254,401.0871,35.3314,399.2109,34.6099,397.4476,34,395.7305,34.0976,395.7305,34.1321,393.9367,34.1861,392.143,33.7641,390.3492,34.1726,388.5555,34,386.7617,33.8612,386.7042,34.7764,385.0122,35.4076,383.2026,36.0543,381.3994,36.782,379.6298,37.6612,377.9229,37.5882,377.7468,39.4903,377.3387,41.2101,376.4909,43.0413,375.9116,44.8254,375.2189,46.5,374.2617"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="12" lengthAdjust="spacingAndGlyphs" textLength="171"
              x="44" y="395.4004">Redirect user to person list
        </text>
        <polygon fill="#FEFECE" filter="url(#fke4gdczpf8i3)"
                 points="298,104.9531,298,104.6797,308,104.275,318,104.6666,328,104.9585,338,105.1694,348,104.7192,358,104.5232,368,104.2958,378,105.1605,388,105.4465,398,104.2317,408,105.6649,418,104.6688,428,105.4286,438,105.6784,448,105.4951,458,104.9433,468,104.4651,478,104.6033,488,104.302,498,105.069,508,105.0046,518,104.4293,528,104.8899,538,105.6616,548,105.1778,558,104.9531,558.0261,105.0161,559.734,105.6039,561.4878,106.3024,563.3291,107.212,565.0075,107.7285,566.8388,108.6143,567.0109,108.6856,567.5474,110.3722,568.0762,112.0558,569.0377,113.9185,569.6139,115.6216,570.5,117.4531,570.6304,117.4531,570.5586,119.2469,570.6196,121.0406,570.2758,122.8344,570.6629,124.6281,570.5,126.4219,570.5549,126.4446,569.6111,128.1247,569.2065,130.0282,568.5286,131.8185,567.7092,133.5502,566.8388,135.2607,566.7611,135.073,565.064,135.976,563.2701,136.6449,561.5444,137.4789,559.8574,138.406,558,138.9219,558,138.321,548,139.4718,538,139.4214,528,139.2954,518,139.1019,508,138.5186,498,138.9773,488,138.7938,478,138.453,468,138.2438,458,138.7839,448,138.9066,438,139.0528,428,139.2494,418,139.5234,408,139.1202,398,138.289,388,139.1326,378,138.1757,368,138.2028,358,138.6026,348,139.229,338,138.235,328,139.2774,318,139.1129,308,139.3947,298,138.9219,297.964,138.835,296.234,138.194,294.3982,137.2975,292.6667,136.6527,290.8574,135.8203,289.1612,135.2607,288.9621,135.1782,288.5177,133.5297,287.8335,131.7819,287.0667,129.9998,286.457,128.2828,285.5,126.4219,285.476,126.4219,285.5385,124.6281,285.3194,122.8344,285.339,121.0406,285.3456,119.2469,285.5,117.4531,285.5079,117.4564,286.4381,115.7706,286.8788,113.8821,287.6106,112.1142,288.6158,110.4595,289.1612,108.6143,289.1274,108.5329,290.8605,107.7168,292.6148,106.9521,294.5542,106.6342,296.2716,105.7803,298,104.9531"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <text fill="#000000" font-family="sans-serif" font-size="12" lengthAdjust="spacingAndGlyphs" textLength="265"
              x="295.5" y="126.0918">Display the form again with error message
        </text>
        <polygon fill="#FEFECE" filter="url(#fke4gdczpf8i3)"
                 points="278.75,414.2305,278.6408,414.1212,281.0813,416.5617,283.4639,418.9444,286.0398,421.5202,288.3721,423.8526,290.75,426.2305,290.8796,426.3601,288.18,428.4605,285.7959,430.8763,283.5163,433.3968,281.0026,435.683,278.75,438.2305,278.7982,438.2787,276.3587,435.8391,273.8858,433.3663,271.469,430.9495,269.0531,428.5336,266.75,426.2305,266.8528,426.3332,269.0806,423.7611,271.5285,421.4089,274.1018,419.1822,276.4632,416.7437,278.75,414.2305"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="none" filter="url(#fke4gdczpf8i3)"
                 points="288.0476,469.991,287.6178,471.7122,286.1675,474.3453,283.6459,476.4466,280.8304,478.1876,278.4153,478.7479,275.0452,478.1349,272.4202,476.1531,271.2545,474.4435,269.2083,472.622,269.4368,469.5389,268.8187,466.5521,270.2557,463.5732,271.8694,461.4247,274.0994,458.9299,277.3914,458.0201,280.9235,458.2504,282.7941,458.9011,285.0067,460.9924,286.6372,462.4822,288.6521,465.1196,289.3358,468.616"
                 style="stroke: #000000; stroke-width: 1.0;"/>
        <polygon fill="#000000" filter="url(#fke4gdczpf8i3)"
                 points="284.9931,469.864,284.3865,471.5896,283.6716,472.3495,282.3611,473.762,281.0425,474.4986,279.3267,474.942,277.3465,474.7658,275.8234,473.4442,274.1457,472.3698,273.764,471.284,273.5067,470.1461,273.4742,468.5505,273.4437,466.9257,274.155,465.0728,275.6539,463.7063,277.3879,462.7205,278.6822,462.6569,280.7789,462.7277,282.3019,463.5961,283.4829,464.5303,284.9155,465.8979,285.4574,467.744,285.2542,469.4503"
                 style="stroke: none; stroke-width: 1.0;"/>
        <path d="M129.5,187.3242 L129.6806,187.3242 L129.3129,194.3242 L129.4263,201.3242 L129.2638,208.3242 L129.3396,215.3242 L129.5,222.3242 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="#A80036"
                 points="125.5,212.3242,125.4262,212.2947,126.3549,214.3462,126.879,216.2358,128.1085,218.4076,128.5787,220.2757,129.5,222.3242,129.4959,222.3226,130.3259,220.3346,130.9572,218.2671,131.9942,216.3619,132.772,214.353,133.5,212.3242,133.6201,212.4443,132.6338,213.058,131.8928,213.917,131.1075,214.7317,130.2723,215.4966,129.5,216.3242,129.3942,216.2184,128.6437,215.4679,127.9224,214.7466,127.2292,214.0534,126.2089,213.0331,125.5,212.3242"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M129.5,128.9531 L129.7738,128.9531 L129.8194,133.8336 L129.2481,138.7141 L129.2136,143.5945 L129.4319,148.475 L129.5,153.3555 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="#A80036"
                 points="125.5,143.3555,125.7008,143.4358,126.2693,145.3432,127.2198,147.4034,128.0893,149.4312,128.91,151.4395,129.5,153.3555,129.5608,153.3798,130.2613,151.34,131.1025,149.3565,131.7308,147.2878,132.601,145.3159,133.5,143.3555,133.5767,143.4322,132.7534,144.2088,131.9378,144.9933,131.016,145.6715,130.3491,146.6046,129.5,147.3555,129.3465,147.202,128.5917,146.4471,127.9746,145.83,127.1885,145.044,126.2935,144.149,125.5,143.3555"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M213.5,116.9531 L213.5,116.9607 L221.5,117.032 L229.5,116.9755 L237.5,116.6791 L245.5,117.0277 L253.5,116.9531 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="#A80036"
                 points="249.5,194.8242,249.4698,194.8121,250.4007,196.8645,251.2587,198.8877,251.6708,200.7325,252.6037,202.7857,253.5,204.8242,253.3702,204.7723,254.1026,202.7452,254.9961,200.7826,256.0021,198.865,256.5615,196.7688,257.5,194.8242,257.3804,194.7046,256.7307,195.6549,255.9511,196.4754,255.1994,197.3236,254.1902,197.9144,253.5,198.8242,253.411,198.7352,252.8165,198.1407,251.8409,197.1651,251.2143,196.5386,250.1271,195.4513,249.5,194.8242"
                 style="stroke: #A80036; stroke-width: 1.5;"/>
        <path d="M253.5,116.9531 L253.8984,116.9531 L254.0288,127.0319 L253.9628,137.1108 L252.6069,147.1896 L254.124,157.2684 L254.401,167.3472 L252.6317,177.426 L253.6974,187.5048 L254.4616,197.5836 L253.4207,207.6625 L253.7662,217.7413 L254.0938,227.8201 L253.0536,237.8989 L254.2986,247.9777 L253.4123,258.0565 L254.3785,268.1353 L254.1842,278.2142 L253.5,288.293 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <path d="M253.5,288.293 L253.5,288.4817 L243.3182,288.279 L233.1364,287.6927 L222.9545,288.4958 L212.7727,289.243 L202.5909,287.8851 L192.4091,289.2264 L182.2273,288.4814 L172.0455,288.9833 L161.8636,288.0676 L151.6818,288.0852 L141.5,288.293 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="#A80036"
                 points="151.5,284.293,151.5464,284.409,149.556,285.2331,147.4232,285.7009,145.4301,286.5183,143.4996,287.4919,141.5,288.293,141.4699,288.2178,143.4915,289.0717,145.4216,289.6969,147.5259,290.7577,149.531,291.5704,151.5,292.293,151.6476,292.4406,150.5496,291.3425,149.873,290.666,148.929,289.722,148.4761,289.2691,147.5,288.293,147.4398,288.2327,148.3827,287.5756,148.9555,286.5485,149.8693,285.8623,150.5885,284.9814,151.5,284.293"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M129.5,256.293 L129.6612,256.293 L129.528,260.293 L129.5746,264.293 L129.33,268.293 L129.3694,272.293 L129.5,276.293 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="#A80036"
                 points="125.5,266.293,125.5755,266.3232,126.3416,268.3096,127.2066,270.3356,128.0139,272.3385,128.5283,274.2243,129.5,276.293,129.5267,276.3036,130.1411,274.2294,131.1157,272.2992,131.8573,270.2759,132.8207,268.3412,133.5,266.293,133.5179,266.3109,132.7607,267.1536,131.8887,267.8816,131.0677,268.6607,130.1533,269.3463,129.5,270.293,129.4665,270.2595,128.7829,269.5758,127.8468,268.6398,127.1423,267.9352,126.1679,266.9608,125.5,266.293"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M129.5,300.293 L129.5802,300.293 L129.6306,304.293 L129.6464,308.293 L129.2008,312.293 L129.6423,316.293 L129.5,320.293 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="#A80036"
                 points="125.5,310.293,125.3818,310.2457,126.4055,312.3352,127.0856,314.2872,127.935,316.307,128.492,318.2098,129.5,320.293,129.2944,320.2107,130.0693,318.2007,130.9787,316.2444,131.6907,314.2092,132.5908,312.2493,133.5,310.293,133.4898,310.2828,132.8177,311.2107,131.7602,311.7532,131.1023,312.6953,130.3077,313.5007,129.5,314.293,129.4403,314.2333,128.6499,313.4429,128.0086,312.8016,127.0301,311.8231,126.1888,310.9817,125.5,310.293"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M129.5,354.2617 L129.2408,354.2617 L129.2106,358.2617 L129.7952,362.2617 L129.5825,366.2617 L129.7945,370.2617 L129.5,374.2617 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="#A80036"
                 points="125.5,364.2617,125.7167,364.3484,126.3722,366.2906,127.1448,368.2797,127.7063,370.1843,128.8887,372.3372,129.5,374.2617,129.6022,374.3026,130.4376,372.3167,131.07,370.2497,132.0075,368.3047,132.7319,366.2745,133.5,364.2617,133.6164,364.3781,132.8387,365.2004,131.8845,365.8462,131.1365,366.6982,130.2985,367.4603,129.5,368.2617,129.6501,368.4118,128.6124,367.3741,127.8122,366.5739,127.0023,365.7641,126.3403,365.102,125.5,364.2617"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M185.75,82.9531 L185.75,83.5912 L176.375,82.2098 L167,81.9788 L157.625,83.0324 L148.25,83.5404 L138.875,83.9058 L129.5,82.9531 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <path d="M129.5,82.9531 L129.687,82.9531 L129.2265,87.3531 L129.2497,91.7531 L129.4073,96.1531 L129.6629,100.5531 L129.5,104.9531 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="#A80036"
                 points="125.5,94.9531,125.6997,95.033,126.2139,96.9187,127.2585,99.0165,127.8759,100.9435,128.6854,102.9473,129.5,104.9531,129.3339,104.8867,130.3325,102.9661,130.9705,100.9013,131.7807,98.9054,132.8815,97.0257,133.5,94.9531,133.6646,95.1177,132.6188,95.6719,131.7994,96.4525,131.0134,97.2666,130.2184,98.0715,129.5,98.9531,129.4025,98.8556,128.8673,98.3204,128.059,97.5121,127.0725,96.5256,126.4037,95.8569,125.5,94.9531"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M371.75,82.9531 L371.75,83.6221 L381.125,83.2134 L390.5,83.5706 L399.875,82.4968 L409.25,83.5727 L418.625,81.9973 L428,82.9531 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <path d="M428,82.9531 L428.3143,82.9531 L428.2578,87.3531 L427.8702,91.7531 L427.7832,96.1531 L427.9671,100.5531 L428,104.9531 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="#A80036"
                 points="424,94.9531,423.9994,94.9529,424.729,96.9247,425.5952,98.9512,426.3535,100.9345,427.3754,103.0233,428,104.9531,428.2203,105.0412,428.8566,102.9758,429.6517,100.9738,430.498,98.9923,431.0993,96.9128,432,94.9531,432.0105,94.9637,431.032,95.5851,430.4556,96.6088,429.5658,97.3189,428.9167,98.2698,428,98.9531,428.0729,99.0261,427.0725,98.0257,426.391,97.3442,425.505,96.4581,424.8612,95.8143,424,94.9531"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M129.5,408.2305 L129.2672,408.2305 L129.4412,411.8305 L129.2607,415.4305 L129.6847,419.0305 L129.2808,422.6305 L129.5,426.2305 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <path d="M129.5,426.2305 L129.5,427.1777 L139.3036,426.4126 L149.1071,425.617 L158.9107,425.8623 L168.7143,425.8754 L178.5179,425.9994 L188.3214,426.9083 L198.125,425.402 L207.9286,427.0513 L217.7321,426.9517 L227.5357,425.8451 L237.3393,426.356 L247.1429,425.5144 L256.9464,426.9641 L266.75,426.2305 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="#A80036"
                 points="256.75,422.2305,256.774,422.2904,258.7636,423.0644,260.8152,423.9935,262.7412,424.6084,264.7247,425.3672,266.75,426.2305,266.7039,426.1152,264.6913,426.8836,262.7386,427.8019,260.6925,428.4867,258.7615,429.4593,256.75,430.2305,256.9251,430.4056,257.5059,429.3864,258.2786,428.5591,259.2103,427.8908,259.9049,426.9854,260.75,426.2305,260.7414,426.2219,259.9408,425.4213,259.1976,424.678,258.2925,423.773,257.6955,423.176,256.75,422.2305"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M428,138.9219 L428.7235,138.9219 L428.2873,148.8291 L427.4621,158.7363 L427.7377,168.6435 L428.7903,178.5506 L427.1091,188.4578 L428.3273,198.365 L427.001,208.2722 L428.8494,218.1794 L428.3494,228.0866 L427.5812,237.9938 L428.7108,247.901 L428.0483,257.8082 L427.3776,267.7154 L427.0046,277.6226 L428.0899,287.5298 L427.8278,297.437 L427.5536,307.3442 L427.8515,317.2513 L427.5797,327.1585 L427.6958,337.0657 L428.6915,346.9729 L428.8058,356.8801 L428.2059,366.7873 L427.3872,376.6945 L428.7811,386.6017 L427.7134,396.5089 L428.3757,406.4161 L428.5696,416.3233 L428,426.2305 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <path d="M428,426.2305 L428,426.8532 L418.1964,426.5533 L408.3929,425.5948 L398.5893,427.1258 L388.7857,426.3177 L378.9821,425.8628 L369.1786,425.502 L359.375,426.0024 L349.5714,426.4467 L339.7679,425.9609 L329.9643,425.4306 L320.1607,426.9732 L310.3571,425.5381 L300.5536,426.4843 L290.75,426.2305 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="#A80036"
                 points="300.75,422.2305,300.8253,422.4187,298.7328,422.9875,296.7045,423.7168,294.7272,424.5734,292.6804,425.2565,290.75,426.2305,290.7931,426.3383,292.6809,426.8578,294.7845,427.9168,296.7247,428.5673,298.7847,429.5172,300.75,430.2305,300.7699,430.2503,299.9965,429.477,299.1025,428.5829,298.3881,427.8686,297.6062,427.0866,296.75,426.2305,296.786,426.2665,297.5561,425.4366,298.1755,424.456,299.0419,423.7223,300.0777,423.1581,300.75,422.2305"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M278.75,50.9531 L278.8269,50.9531 L278.6562,54.9531 L278.9987,58.9531 L278.7364,62.9531 L278.9363,66.9531 L278.75,70.9531 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="#A80036"
                 points="274.75,60.9531,274.9265,61.0237,275.623,62.9823,276.4095,64.9769,276.9786,66.8846,278.0192,68.9808,278.75,70.9531,278.8572,70.996,279.3656,68.8794,280.2599,66.9171,281.1231,64.9424,282.0783,63.0044,282.75,60.9531,282.8488,61.0519,281.7888,61.5919,280.9953,62.3985,280.2909,63.294,279.5515,64.1546,278.75,64.9531,278.9199,65.123,278.0829,64.2861,277.1147,63.3178,276.4192,62.6224,275.5087,61.7118,274.75,60.9531"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
        <path d="M278.75,438.2305 L278.8432,438.2305 L278.4379,442.2305 L278.8673,446.2305 L279.0148,450.2305 L278.7943,454.2305 L278.75,458.2305 "
              fill="#A80036" style="stroke: #A80036; stroke-width: 1.5;"/>
        <polygon fill="#A80036"
                 points="274.75,448.2305,274.7426,448.2275,275.5315,450.2231,276.3094,452.2142,277.3258,454.3008,277.9534,456.2318,278.75,458.2305,278.7085,458.2139,279.7475,456.3094,280.538,454.3057,281.2074,452.2534,282.094,450.2881,282.75,448.2305,282.8414,448.3219,281.779,448.8594,281.2206,449.901,280.1815,450.462,279.6203,451.5008,278.75,452.2305,278.7274,452.2079,278.0577,451.5382,277.151,450.6315,276.3623,449.8428,275.4252,448.9056,274.75,448.2305"
                 style="stroke: #A80036; stroke-width: 1.0;"/>
    </g>
</svg>
</div>

{% comment %}
@startuml
skinparam backgroundColor Ivory
skinparam handwritten true

title Store person with address into database

start
if (User filled all required fields) then (yes)
  if (User filled address fields) then (yes)
    :Store address into database;
    :Obtain address ID from database;
  else (no)
  endif
  :Store person record into database;
  :Redirect user to person list;
else (no)
  :Display the form again with error message;
endif

stop
@enduml
{% endcomment %}

{: .note}
Some UML diagrams are less intuitive than Use-Case, Activity or Sequence diagrams -- they are focused on designing
much more complicated systems than this application. Do not bother with Class or Object diagrams for now, you just
need to be able to decompose the Use-Cases to individuals steps that can be rewritten as lines of your program.

Once you know what a user can do, you can start designing user interface for that actions. Take a pencil and a piece of
paper and start drawing forms and layout of individual screens. You should create so called [wireframe](https://en.wikipedia.org/wiki/Website_wireframe)
model for each screen of your application and you can append some notes to it. You should be able to identify required
form fields from the supplied [Entity-Relationship diagram](/walkthrough-slim/database-intro/#database-schema). If you
want to use software to draw wireframes, try [Pencil project](https://pencil.evolus.vn/).

You may end up with something like this:

{: .image-popup}
![Example wireframe](/course/example-wireframe.png)

{: .note}
Some people start with wireframing first -- it is up to you to decide whether you feel more confident drawing the
user interface or thinking about all possible functions first.

After you have the wireframes with comments and list of actions, you can start coding: assign a route or filename to
each action (depending on walkthrough version), prepare the template and display it -- you can start with static
templates. Afterwards start coding logic -- retrieve data from database and display them (pass the data into template
and show them to the visitor), prepare *POST* routes for data modifications when a page contains a form. Always think
about what the user should see or where to redirect him after *POST* action.

{: .note}
I supplied the database structure for you so you do not have to bother designing it. In real world, you would have to
analyse the assignment, find potential database entities and their attributes and create [Entity-Relationship diagram](/articles/database-design/)
by yourself. It is a good idea to crosscheck ERD with wireframe models of user interface to be sure that all forms and
inputs are mapped to entities and attributes and vice-versa.

UML diagrams are nice, another, more important thing to know is the **grasp of inner working of web applications,
databases and related technologies** -- without this, you end up with Use-Case diagrams and superficial scenarios,
sequence or activity diagrams and still no idea of how to start actually coding. To be able to write the code,
**you have to learn how to solve isolated problems and make a lot of prototypes**. Read [article about problem solving](/articles/problem-solving/).

### Why do we use some "framework", how does it work?
Framework is a software which defines skeleton of your project and provides some basic means to write an application
(e.g. logging and routing in Slim). Check out this [walkthrough](/walkthrough-slim/slim-intro/#project-structure).

There are many frameworks for PHP, some of them provide more functionality and some of them less -- [Slim](https://www.slimframework.com/)
is a micro-framework and does not provide much functions, but it is very easy to use.

Framework is usually created by community of developers who share similar opinions about implementation of common
functions. Each framework has [documentation](https://www.slimframework.com/docs/).

In reality, you always want to use some framework as you do not want to write your own solution for everything and you
need to deliver results in reasonable time. Great advantage is that bugs in framework's code are fixed by others (you
just update to newer version). Once you learn to use one framework, you will find easier to learn and use another one --
they all have similar core concepts.

Never write your own framework (unless you have 10+ years of experience and a team of developers and really lot of time).

### When to use *GET* and when to use *POST*?
Generally, *POST* should be used to modify state (obviously to modify or remove record in database, less obviously for
logout). Use *GET* whenever you want to let users revisit that same page in current state (e.g. save the link to
favourites or share URL with others). You usually have one *GET* route and one *POST* route for forms -- *GET* renders
empty form and *POST* stores the values.

Take a look [here](/articles/http/#when-to-use-get-or-post-method).

## PHP questions

### My code is too long, how do I organise it?
Use [include](http://php.net/manual/en/function.include.php) or [require](http://php.net/manual/en/function.require.php)
functions. Take a look [here](/walkthrough-slim/login/#tidy-up-your-code).

### What is Composer and how do I install it?
[Composer](https://getcomposer.org/) is a tool for downloading PHP libraries. You usually find a command in form
`composer require someting` on a web site of particular library which downloads the source code into `/vendor` folder.
The dependency is noted in `composer.json` file in the root of the project.

You can read more detailed [description](/course/technical-support/#composer) or try to [use it](/walkthrough-slim/slim-intro/#task----play-with-composer).

Before you can use it on your computer, you have to install [PHP](/course/technical-support/#php-as-command-line-script-interpreter)
as command line tool.

## Framework related questions (Slim)

### What is a route or routing?
Route is a combination of HTTP method (*GET*, *POST* or others) and a path, e.g. `GET /persons` or `POST /new-person`.
Routing is a mechanism which is implemented in a framework to map routes on actual code. You can use constructions
like `$app->get('/some/route', function($request, $response, $args) { ... })` to match a route and a piece of code
which gets executed. If you are having difficulties to understand routing, think of a route as of *IF* statement:

``` php?start_inline=1
$app->get('/some/route', function($request, $response, $args) {
    //code
});
```

This code can be understood like the following one:

``` php?start_inline=1
if($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] == '/some/route') {
    //code
}
```

{: .note}
The variable [`$_SERVER`](http://php.net/manual/en/reserved.variables.server.php) is an actual thing which contains
some valuable information about the server where you execute PHP scripts and the request itself. Check out
[`phpinfo()`](http://php.net/manual/en/function.phpinfo.php) function too.

Basic routing is explained in the [walkthrough](/walkthrough-slim/slim-backend/#how-does-it-work). Then check out this
[article](/articles/http/) and this [walkthrough](/articles/http/#when-to-use-get-or-post-method).
Take a look at [named routes](/walkthrough-slim/named-routes/) too. 

An important note is that routes are *virtual*, the paths in your address bar are not paths to actual files or folders.
This *magic* is enabled by [mod_rewrite](/course/technical-support/#configuration-of-mod_rewrite) plugin of
[Apache web server](/course/technical-support/#apache-web-server). 

### When to use `getParsedBody()` and when to use `getQueryParam(...)`, what is the difference?
Both methods are used to get access to script inputs. Method `getParsedBody()` reads data from [HTTP's](/articles/http/)
body (hence the name of the method). The browser sends the information in the body when you use `<form method="post">`
(it packs the input names and values into a string and puts that string into the request payload -- read that
[HTTP article](/articles/http/)). Therefore this method is meaningful only in *POST* routes.

Method `getQueryParam(...)` fetches one parameter (given by its name) from the *query*. The *query* is part of the
URL and you can see it in the browser's address bar. You can pass query parameters in links
(`<a href="/route?param=value&param2=value2">link</a>`) and also in form's `action` attribute. Therefore you can
use this method in either *GET* or *POST* routes.

Read more in walkthrough article about [passing values](/walkthrough-slim/passing-values/).

{: .note}
There is also `getQueryParams()` function which returns all query parameters as associative array.

## Templating engine questions

### What is templating engine and why do we use it?
Templating engine is a library which takes as input HTML code with some macros in specific syntax and generates HTML code.
We want to use it to divide PHP code and HTML code, because generating HTML in you PHP can look very ugly:

{: .solution}
{% highlight php %}
{% include /faq/ugly.php %}
{% endhighlight %}

In the example above, note that HTML in `echo` is just a string, therefore it is tedious and error prone to write code
this way.

It has many benefits:

- separation of concerns -- PHP and HTML in separate files, different people with different specialisation can work
  independently, there is an interface between template and PHP code (names of variables)
- security (no [XSS](/articles/security/xss/))
- real approach -- templating is common approach to generate HTML code

### How does template engine work
It transforms HTML code with macros to executable PHP code. The actual code that get executed is the PHP file generated
by this transformation.

Here is a quick example of templating engine input and possible output:

~~~ html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{$title|capitalize}</title>
    </head>
    <body>
        {if $something}
            <p>
                {$somethingElese}
            </p>
        {/if}
    </body>
</html>
~~~

~~~ php
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php htmlspecialchars(strtoupper($title)); ?></title>
    </head>
    <body>
        <?php if($something) { ?>
            <p>
                <?php echo htmlspecialchars($somethingElese); ?>
            </p>
        <?php } ?>
    </body>
</html>
~~~

{: .note}
That thing behind `|` is a [filter](https://github.com/nette/latte#filters) -- it is a convenient way to transform
values in template.

### How do the variables come into the template?
There is an interface between a PHP code and a template. PHP simply pushes variables into template and template tells,
what variable it needs to work (if it is documented). Templating engine usually receives an associative array.
The keys in that array are extracted and become variables in context of transformed template (actual PHP code -- see
previous question).

The tricky part is, when you need to pass an array into the template (i.e. a result of database query). Arrays in PHP
can be multi-dimensional, and you can combine associative and ordinal arrays together. See following example.

PHP code:

~~~ php?start_inline=1
$app->get(function($request, $response, $args) {
    $tplVars = [];  //an empty array
    $tplVars['title'] = 'Title of a page';  //a key title with a scalar value
    $tplVars['data'] = [    //a key data which contains another ordinal array (no keys given)
        [                   //but this array contains yet another associative arrays!
            'first_name' => 'John',
            'last_name' => 'Test'
        ],
        [
            'first_name' => 'Jane',
            'last_name' => 'Example'
        ]
    ];
    //$tplVars['data'][0]['first_name'] contains 'John'
    //$tplVars['data'][1]['last_name'] contains 'Example'
    return $this->view->render($response, 'template.latte', $tplVars);
});
~~~

Template will have access to scalar variable `$title` and array `$data`:

~~~ html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{$title}</title>
    </head>
    <body>
        {foreach $data as $v}
            <p>
                {$v['first_name']} {$v['last_name']}
            </p>
        {/foreach}
    </body>
</html>
~~~

Result that is received by the browser:

~~~ html
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Title of a page</title>
    </head>
    <body>
        <p>
            John Test
        </p>
        <p>
            Jane Example
        </p>
    </body>
</html>
~~~

### Templating engine errors are difficult to read and point to strange places.
This is unfortunately true. The source of this problem comes from the general idea of templating engine itself --
it transforms HTML code with macros to executable PHP code. The actual code that get executed is the PHP file somewhere
in cache and therefore the errors are so difficult to read.

You can open the compiled template in cache and look for the line with error. You should be able to identify problem
source by the surrounding HTML code. Read more in [debugging article](/articles/debugging/backend/).
