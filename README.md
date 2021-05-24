[![Build Status](https://travis-ci.com/alexander97olsson/mvcProject.svg?branch=main)](https://travis-ci.com/alexander97olsson/mvcProject)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alexander97olsson/mvcProject/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/alexander97olsson/mvcProject/?branch=main)

[![Code Coverage](https://scrutinizer-ci.com/g/alexander97olsson/mvcProject/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/alexander97olsson/mvcProject/?branch=main)

[![Build Status](https://scrutinizer-ci.com/g/alexander97olsson/mvcProject/badges/build.png?b=main)](https://scrutinizer-ci.com/g/alexander97olsson/mvcProject/build-status/main)

# mvc

Kursrepo för projektet i MVC-kursen.

GitHub för detta repo är publicerat på:

* https://dbwebb-se.github.io/mvc/

Hur programmet fungerar:

Min applikation handlar om att spela Yatzy mot sig själv och man får även att spara sina poäng i ett highscore med hjälp av en databas. För att starta spelet går man in under rubriken "Yatzy" och väljer "Start game". Spelet kommer först att få igenom 6 rundor. Varje runda kommer bestå av 3 kast av tärningshanden där spelaren kommer få efter varje slag välja om hen vill spara eller fortsätta. Varje runda kommer spelaren att spara tärningar baserat på runda. Till exempel om det är runda 1 ska spelaren spara alla tärningar som har 1. Skulle spelaren få en totalpoäng på 50 när alla 6 rundor är klara får hen även en bonus med 50 poäng. Efter 6 rundor startar nästa del av spelet. Denna del kommer spelaren ha möjlighet att spara tärningar baserat på vad hen känner för. De val som finns är:

* Par
* Triss
* Fyrtal
* Liten stege
* Stor stege
* Kåk
* Chans
* Yatzy

När spelaren valt ett val kommer det valet att försvinna och det kommer inte finnas någon möjlighet att spela om den. Det är alltså viktigt att spara tärningar efter vad som finns kvar och välja försiktigt. När spelet är slut och alla rundor är spelade får spelaren möjlighet att spara ner sin poäng genom att skriva in sitt namn. Poängen sparas ner i en databas som även läses upp via underrubriken "Highscore". Där kan man se alla sparade poäng och personer. Det går att rangordna "highscore" listan via lite olika val. Det finns även en flik som heter "Average" där man kan se vad genomsnittliga poängen ligger på, även den sparad i en databas.


För att spela kan man antingen ladda ner spelet eller spela online på studentservern:

Spela på studentservern:

* http://www.student.bth.se/~alos17/dbwebb-kurser/mvc/me/proj/public/yatzystart

Ladda ner:

* https://dbwebb-se.github.io/mvc/

```
 .
..:  Copyright (c) 2021 Alexander Olsson, alexander93olsson@hotmail.com
```