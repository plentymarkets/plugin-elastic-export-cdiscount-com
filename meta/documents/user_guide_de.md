# User Guide für das ElasticExportCdiscountCOM Plugin

<div class="container-toc"></div>

## 1 Bei Cdiscount registrieren

Auf dem Marktplatz Cdiscount bietest du deine Artikel zum Verkauf an. Weitere Informationen zu diesem Marktplatz findest du auf der Handbuchseite [Cdiscount einrichten](https://knowledge.plentymarkets.com/maerkte/cdiscount).

<div class="alert alert-info" role="alert">
Dieses Plugin stellt das Exportformat *CdiscountCOM* bereit. Dieses Exportformat benötigst du nur, wenn Cdiscount eine CSV-Datei anfordert, die deine Artikeldaten enthält. Den Verkauf deiner Artikel auf dem Marktplatz Cdiscount konfigurierst du im Menü **Einrichtung » Märkte » Cdiscount.com** <a href="https://knowledge.plentymarkets.com/maerkte/cdiscount" target="_blank">des plentymarkets Backend</a>.
</div>

## 2 Das Format CdiscountCOM-Plugin in plentymarkets einrichten

Mit der Installation dieses Plugins erhältst du das Exportformat **CdiscountCOM-Plugin**, mit dem du Daten über den elastischen Export zu Cdiscount.com überträgst. Um dieses Format für den elastischen Export nutzen zu können, installiere zunächst das Plugin **Elastic Export** aus dem plentyMarketplace, wenn noch nicht geschehen.

Sobald beide Plugins in deinem System installiert sind, kann das Exportformat **CdiscountCOM-Plugin** erstellt werden. Weitere Informationen findest du auf der Handbuchseite [Elastischer Export](https://knowledge.plentymarkets.com/daten/daten-exportieren/elastischer-export).

Neues Exportformat erstellen:

1. Öffne das Menü **Daten » Elastischer Export**.
2. Klicke auf **Neuer Export**.
3. Nimm die Einstellungen vor. Beachte dazu die Erläuterungen in Tabelle 1.
4. **Speichere** die Einstellungen.<br/>
→ Eine ID für das Exportformat **CdiscountCOM-Plugin** wird vergeben und das Exportformat erscheint in der Übersicht **Exporte**.

In der folgenden Tabelle findest du Hinweise zu den einzelnen Formateinstellungen und empfohlenen Artikelfiltern für das Format **CdiscountCOM-Plugin**.

| **Einstellung**                                     | **Erläuterung** |
| :---                                                | :--- |
| **Einstellungen**                                   | |
| **Name**                                            | Name eingeben. Unter diesem Namen erscheint das Exportformat in der Übersicht im Tab **Exporte**. |
| **Typ**                                             | Typ **Artikel** aus der Dropdown-Liste wählen. |
| **Format**                                          | **CdiscountCOM-Plugin** wählen. |
| **Limit**                                           | Zahl eingeben. Wenn mehr als 9999 Datensätze an die Preissuchmaschine übertragen werden sollen, wird die Ausgabedatei wird für 24 Stunden nicht noch einmal neu generiert, um Ressourcen zu sparen. Wenn mehr mehr als 9999 Datensätze benötigt werden, muss die Option **Cache-Datei generieren** aktiv sein. |
| **Cache-Datei generieren**                          | Häkchen setzen, wenn mehr als 9999 Datensätze an die Preissuchmaschine übertragen werden sollen. Um eine optimale Performance des elastischen Exports zu gewährleisten, darf diese Option bei maximal 20 Exportformaten aktiv sein. |
| **Bereitstellung**                                  | **URL** wählen. Mit dieser Option kann ein Token für die Authentifizierung generiert werden, damit ein externer Zugriff möglich ist. |
| **Token, URL**                                      | Wenn unter **Bereitstellung** die Option **URL** gewählt wurde, auf **Token generieren** klicken. Der Token wird dann automatisch eingetragen. Die URL wird automatisch eingetragen, wenn unter **Token** der Token generiert wurde. |
| **Dateiname**                                       | Der Dateiname muss auf **.csv** enden, damit Cdiscount.com die Datei erfolgreich importieren kann. |
| **Artikelfilter**                                   | |
| **Artikelfilter hinzufügen**                        | Artikelfilter aus der Dropdown-Liste wählen und auf **Hinzufügen** klicken. Standardmäßig sind keine Filter voreingestellt. Es ist möglich, alle Artikelfilter aus der Dropdown-Liste nacheinander hinzuzufügen.<br/> **Varianten** = **Alle übertragen** oder **Nur Hauptvarianten übertragen** wählen.<br/> **Märkte** = **Cdiscount.com** wählen.<br/> **Währung** = Währung wählen.<br/> **Kategorie** = Aktivieren, damit der Artikel mit Kategorieverknüpfung übertragen wird. Es werden nur Artikel, die dieser Kategorie zugehören, übertragen.<br/> **Bild** = Aktivieren, damit der Artikel mit Bild übertragen wird. Es werden nur Artikel mit Bildern übertragen.<br/> **Mandant** = Mandant wählen.<br/> **Bestand** = Wählen, welche Bestände exportiert werden sollen.<br/> **Markierung 1 - 2** = Markierung wählen.<br/> **Hersteller** = Einen, mehrere oder **ALLE** Hersteller wählen.<br/> **Aktiv** = Nur aktive Varianten werden übertragen. |
| **Formateinstellungen**                             | |
| **Produkt-URL**                                     | Wählen, ob die URL des Artikels oder der Variante an das Preisportal übertragen wird. Varianten URLs können nur in Kombination mit dem Ceres Webshop übertragen werden. |
| **Mandant**                                         | Mandant wählen. Diese Einstellung wird für den URL-Aufbau verwendet. |
| **URL-Parameter**                                   | Suffix für die Produkt-URL eingeben, wenn dies für den Export erforderlich ist. Die Produkt-URL wird dann um die eingegebene Zeichenkette erweitert, wenn weiter oben die Option **übertragen** für die Produkt-URL aktiviert wurde. |
| **Auftragsherkunft**                                | **Cdiscount.com** wählen. Die Produkt-URL wird um die gewählte Auftragsherkunft erweitert, damit die Verkäufe später analysiert werden können. |
| **Marktplatzkonto**                                 | Marktplatzkonto aus der Dropdown-Liste wählen. |
| **Sprache**                                         | Sprache aus der Dropdown-Liste wählen. |
| **Artikelname**                                     | **Name 1**, **Name 2** oder **Name 3** wählen. Die Namen sind im Tab **Texte** eines Artikels gespeichert. Im Feld **Maximale Zeichenlänge (def. Text)** optional eine Zahl eingeben, wenn die Preissuchmaschine eine Begrenzung der Länge des Artikelnamen beim Export vorgibt. |
| **Vorschautext**                                    | Diese Option ist für dieses Format nicht relevant. |
| **Beschreibung**                                    | Wählen, welcher Text als Beschreibungstext übertragen werden soll.<br/> Im Feld **Maximale Zeichenlänge (def. Text)** optional eine Zahl eingeben, wenn die Preissuchmaschine eine Begrenzung der Länge der Beschreibung beim Export vorgibt.<br/> Option **HTML-Tags entfernen** aktivieren, damit die HTML-Tags beim Export entfernt werden.<br/> Im Feld **Erlaubte HTML-Tags, kommagetrennt (def. Text)** optional die HTML-Tags eingeben, die beim Export erlaubt sind. Wenn mehrere Tags eingegeben werden, mit Komma trennen. |
| **Zielland**                                        | Zielland aus der Dropdown-Liste wählen. |
| **Barcode**                                         | ASIN, ISBN oder eine EAN aus der Dropdown-Liste wählen. Der gewählte Barcode muss mit der oben gewählten Auftragsherkunft verknüpft sein. Andernfalls wird der Barcode nicht exportiert. |
| **Bild**                                            | **Erstes Bild** wählen. |
| **Bildposition des Energieetiketts**                | Diese Option ist für dieses Format nicht relevant. |
| **Bestandspuffer**                                  | Der Bestandspuffer für Varianten mit der Beschränkung auf den Netto-Warenbestand. |
| **Bestand für Varianten ohne Bestandsbeschränkung** | Der Bestand für Varianten ohne Bestandsbeschränkung. |
| **Bestand für Varianten ohne Bestandsführung**      | Der Bestand für Varianten ohne Bestandsführung. |
| **Währung live umrechnen**                          | Diese Option ist für dieses Format nicht relevant. |
| **Verkaufspreis**                                   | Diese Option ist für dieses Format nicht relevant. |
| **Angebotspreis**                                   | Diese Option ist für dieses Format nicht relevant. |
| **UVP**                                             | Diese Option ist für dieses Format nicht relevant. |
| **Versandkosten**                                   | Diese Option ist für dieses Format nicht relevant. |
| **MwSt.-Hinweis**                                   | Diese Option ist für dieses Format nicht relevant. |
| **Artikelverfügbarkeit**                            | Diese Option ist für dieses Format nicht relevant. |

## 3 Verfügbare Spalten der Exportdatei

Öffne das Exportformat **CdiscountCOM-Plugin** im Menü **Daten » Elastischer Export**, um die Exportdatei herunterzuladen und ggf. anzupassen.

| **Spaltenbezeichnung**    | **Erläuterung** |
| :---                      | :--- |
| **Sku parent**            | **Pflichtfeld**<br/> Die **Parent-SKU** der Variante. |
| **Your reference**        | **Pflichtfeld**<br/> Die **SKU** der Variante. |
| **EAN**                   | **Pflichtfeld**<br/> Entsprechend der Formateinstellung **Barcode**. |
| **Brand**                 | **Pflichtfeld**<br/> Der **Hersteller** des Artikels. Der **Externe Name** unter **Einstellungen » Artikel » Hersteller** wird bevorzugt, wenn vorhanden. |
| **Nature of product**     | **Pflichtfeld**<br/> Der Produkttyp einer Variante. Definiert, ob die Variante ein Einzelartikel oder eine Variante eines Artikels ist. |
| **Category code**         | **Pflichtfeld**<br/> Der **Kategoriepfad der Standardkategorie** für den in den Formateinstellungen definierten **Mandanten**. |
| **Basket short wording**  | **Pflichtfeld**<br/> Entsprechend der Formateinstellung **Artikelname**. |
| **Basket long wording**   | **Pflichtfeld**<br/> Entsprechend der Formateinstellung **Vorschautext**. |
| **Product description**   | **Pflichtfeld**<br/> Entsprechend der Formateinstellung **Beschreibung**. |
| **Picture 1 (jpeg)**      | **Pflichtfeld**<br/> Erstes Bild der Variante. |
| **Size**                  | Die Größe. Entsprechend des am Artikel hinterlegten Merkmals **size**. |
| **Marketing color**       | Die Farbe. Entsprechend des am Artikel hinterlegten Merkmals **color**. |
| **Marketing description** | Die Marketing-Beschreibung Entsprechend des am Artikel hinterlegten Merkmals **marketing_description**. |
| **Picture 2 (jpeg)**      | Zweites Bild der Variante. |
| **Picture 3 (jpeg)**      | Drittes Bild der Variante. |
| **Picture 4 (jpeg)**      | Viertes Bild der Variante. |
| **ISBN / GTIN**           | Die ISBN der Variante. |
| **MFPN**                  | Das Modell der Variante. |
| **Length**                | Die Länge der Variante in Zentimetern. |
| **Width**                 | Die Breite der Variante in Zentimetern. |
| **Height**                | Die Höhe der Variante in Zentimetern. |
| **Weight**                | Das Gewicht der Variante in Kilogramm. |
| **Main color**            | Die Farbe. Entsprechend des am Artikel hinterlegten Merkmals **main_color**. |
| **Gender**                | Das Geschlecht. Entsprechend des am Artikels hinterlegten Merkmals **gender**. |
| **Type of public**        | Die Zielgruppe. Entsprechend des am Artikel hinterlegten Merkmals **type_of_public**. |
| **Sports**                | Entsprechend des am Artikel hinterlegten Merkmals **sports**. |
| **Comment**               | Entsprechend es am Artikel hinterlegten Merkmals **comment**. |

## 4 Licence
This project is licensed under the GNU AFFERO GENERAL PUBLIC LICENSE.- find further information in the [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-cdiscount-com/blob/master/LICENSE.md).
