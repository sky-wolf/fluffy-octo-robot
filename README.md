# fluffy-octo-robot
The Wolf PHP Framvork

Wolf MVC ramverk är ett projekt som först skapades för att undersöka hur MVC fungerar under huven.

Tanken är att om det blir bra så ska det kunna användas i privata projekt.

Det som redan finns är:

PSR-4 Autoloader.

Custom Routs, som läses in från en fil. Routen har formatet post (’URI prefix’, [’controller’,’action’]), kan även fås i get. Andra metoder kommer implementeras vid behov.

Controllers: använder mig av callback på dessa, den har även till gång till view och validering.

Validering ger dig möjligheten att validera inkommande data. Funktionen finns men inte alla tänkta tester.

View har en koppling till en Template Engien.

För att förstå hur template engien fungerar, så skapade jag en väldig simpel sådan. Den har för närvarande möjligheten att från en view först se om det finns en temp fil. Om den inte finns så läser den i view filen och kollar om det finns template hänvisningar. Finns de så hämtas de och kombineras. Sedan gås den igenom för att omvandla template syntaxen till html och PHP som sedan körs igenom en PHP till html renderare. Detta sparas i en temp fil som sedan används. Omvandlaren har tillgång till att omvandla många av de vanligaste iterationerna, men även utskrift. Den kommer att utökas med tiden.

Databas med möjligheten att skapa migrationer utifrån migrationsfiler. Alla delar finns inte med men kommer. Möjligheten att skapa komplexa SQL frågor kommer.

Kommnad.
Middlewares.
dependency-injection.
HTTP Message Interface  
