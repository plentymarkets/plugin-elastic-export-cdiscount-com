# User Guide für das ElasticExportCdiscountCOM Plugin

<div class="container-toc"></div>

## 1 Bei Cdiscount registrieren

Auf dem Marktplatz Cdiscount bieten Sie Ihre Artikel zum Verkauf an. Weitere Informationen zu diesem Marktplatz finden Sie auf der Handbuchseite [Cdiscount einrichten](https://knowledge.plentymarkets.com/omni-channel/multi-channel/cdiscount).

## 2 Elastic Export CdiscountCOM-Plugin in plentymarkets einrichten

Um dieses Format nutzen zu können, benötigen Sie das Plugin Elastic Export.

Auf der Handbuchseite [Daten exportieren](https://www.plentymarkets.eu/handbuch/datenaustausch/daten-exportieren/#4) werden die einzelnen Formateinstellungen beschrieben.

In der folgenden Tabelle finden Sie spezifische Hinweise zu den Einstellungen, Formateinstellungen und empfohlenen Artikelfiltern für das Format **CdiscountCOM-Plugin**.
<table>
    <tr>
        <th>
            Einstellung
        </th>
        <th>
            Erläuterung
        </th>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Einstellungen
        </td>
    </tr>
    <tr>
        <td>
            Format
        </td>
        <td>
            <b>CdiscountCOM-Plugin</b> wählen.
        </td>
    </tr>
    <tr>
        <td>
            Bereitstellung
        </td>
        <td>
            <b>URL</b> wählen.
        </td>
    </tr>
    <tr>
        <td>
            Dateiname
        </td>
        <td>
            Der Dateiname muss auf <b>.csv</b> enden, damit Cdiscount.com die Datei erfolgreich importieren kann.
        </td>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Artikelfilter
        </td>
    </tr>
    <tr>
        <td>
            Aktiv
        </td>
        <td>
            <b>Aktiv</b> wählen.
        </td>
    </tr>
    <tr>
        <td>
            Märkte
        </td>
        <td>
            <b>Cdiscount.com</b> wählen.
        </td>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Formateinstellungen
        </td>
    </tr>
    <tr>
        <td>
            Auftragsherkunft
        </td>
        <td>
            <b>Cdiscount.com</b> wählen.
        </td>
    </tr>
    <tr>
        <td>
            Vorschautext
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>
    </tr>
    <tr>
		<td>
			Barcode
		</td>
		<td>
			<b>GTIN 13</b> wählen.
		</td>
	</tr>
    <tr>
        <td>
            Bild
        </td>
        <td>
            <b>Erstes Bild</b> wählen.
        </td>
    </tr>
    <tr>
		<td>
			Bildposition des Energieettiketts
		</td>
		<td>
			Diese Option ist für dieses Format nicht relevant.
		</td>
	</tr>
    <tr>
        <td>
            Angebotspreis
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>
    </tr>
    <tr>
		<td>
			UVP
		</td>
		<td>
			Diese Option ist für dieses Format nicht relevant.
		</td>
	</tr>
	<tr>
		<td>
			Versandkosten
		</td>
		<td>
			Diese Option ist für dieses Format nicht relevant.
		</td>
	</tr>
    <tr>
        <td>
            MwSt.-Hinweis
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>
    </tr>
    <tr>
		<td>
			Artikelverfügbarkeit überschreiben
		</td>
		<td>
			Diese Option ist für dieses Format nicht relevant.
		</td>
	</tr>
</table>

## 3 Übersicht der verfügbaren Spalten
<table>
    <tr>
        <th>
            Spaltenbezeichnung
        </th>
        <th>
            Erläuterung
        </th>
    </tr>
    <tr>
    	<td>
    		Sku parent
    	</td>
    	<td>
    		<b>Pflichtfeld</b><br>
    		<b>Inhalt:</b> Die <b>Parent SKU</b> der Variante.
    	</td>
    </tr>
    <tr>
    	<td>
    		Your reference
    	</td>
    	<td>
    		<b>Pflichtfeld</b><br>
    		<b>Inhalt:</b> Die <b>SKU</b> der Variante. 
    	</td>
    </tr>
    <tr>
    	<td>
    		EAN
    	</td>
    	<td>
    		<b>Pflichtfeld</b><br>
			<b>Inhalt:</b> Entsprechend der Formateinstellung <b>Barcode</b>.
    	</td>
    </tr>
    <tr>
        <td>
            Brand
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Der <b>Herstellers</b> des Artikels. Der <b>Externe Name</b> unter <b>Einstellungen » Artikel » Hersteller</b> wird bevorzugt, wenn vorhanden.
        </td>
    </tr>
	<tr>
		<td>
			Nature of product
		</td>
		<td>
			<b>Pflichtfeld</b><br>
			<b>Inhalt:</b> Der <b>Produkttyp</b> einer Variante. Definiert, ob die Variante ein <b>Einzelartikel</b> oder eine <b>Variante eines Artikels</b> ist.
		</td>
	</tr>
	<tr>
		<td>
			Category of product
		</td>
		<td>
			<b>Pflichtfeld</b><br>
			<b>Inhalt:</b> Der <b>Kategoriepfad der Standardkategorie</b> für den in den Formateinstellungen definierten <b>Mandanten</b>.
		</td>
	</tr>
	<tr>
		<td>
			Basket short wording
		</td>
		<td>
			<b>Pflichtfeld</b><br>
			<b>Inhalt:</b> Entsprechend der Formateinstellung <b>Artikelname</b>.
		</td>
	</tr>
	<tr>
    	<td>
    		Basket long wording
    	</td>
    	<td>
    		<b>Pflichtfeld</b><br>
    		<b>Inhalt:</b> Entsprechend der Formateinstellung <b>Vorschautext</b>.
    	</td>
    </tr>
	<tr>
    	<td>
    		Product description
    	</td>
    	<td>
    		<b>Pflichtfeld</b><br>
    		<b>Inhalt:</b> Entsprechend der Formateinstellung <b>Beschreibung</b>.
    	</td>
    </tr>
	<tr>
    	<td>
    		Picture 1 (jpeg)
    	</td>
    	<td>
    		<b>Pflichtfeld</b><br>
    		<b>Inhalt:</b> Erstes Bild der Variante.
    	</td>
    </tr>
	<tr>
    	<td>
    		Size
    	</td>
    	<td>
    		<b>Inhalt:</b> Die <b>Größe</b>. Entsprechend des am Artikel hinterlegten Merkmals <b>size</b>.
    	</td>
    </tr>
	<tr>
    	<td>
    		Marketing color
    	</td>
    	<td>
    		<b>Inhalt:</b> Die <b>Farbe</b>. Entsprechend des am Artikel hinterlegten Merkmals <b>color</b>.
    	</td>
    </tr>
	<tr>
    	<td>
    		Marketing description
    	</td>
    	<td>
    		<b>Inhalt:</b> Die <b>Marketing Beschreibung</b>. Entsprechend des am Artikel hinterlegten Merkmals <b>marketing_description</b>.
    	</td>
    </tr>
	<tr>
    	<td>
    		Picture 2 (jpeg)
    	</td>
    	<td>
    		<b>Inhalt:</b> Zweites Bild der Variante.
    	</td>
    </tr>
	<tr>
    	<td>
			Picture 3 (jpeg)
		</td>
		<td>
			<b>Inhalt:</b> Drittes Bild der Variante.
		</td>
    </tr>
	<tr>
    	<td>
			Picture 4 (jpeg)
		</td>
		<td>
			<b>Inhalt:</b> Viertes Bild der Variante.
		</td>
    </tr>
    <tr>
		<td>
			ISBN / GTIN
		</td>
		<td>
			<b>Inhalt:</b> Die <b>ISBN</b> der Variante.
		</td>
	</tr>
	<tr>
		<td>
			MFPN
		</td>
		<td>
			<b>Inhalt:</b> Das <b>Model</b> der Variante.
		</td>
	</tr>
	<tr>
		<td>
			Length
		</td>
		<td>
			<b>Inhalt:</b> Die <b>Länge</b> der Variante in Zentimentern.
		</td>
	</tr>
	<tr>
		<td>
			Width
		</td>
		<td>
			<b>Inhalt:</b> Die <b>Breite</b> der Variante in Zentimentern.
		</td>
	</tr>
	<tr>
		<td>
			Height
		</td>
		<td>
			<b>Inhalt:</b> Die <b>Höhe</b> der Variante in Zentimentern.
		</td>
	</tr>
	<tr>
		<td>
			Weight
		</td>
		<td>
			<b>Inhalt:</b> Das <b>Gewicht</b> der Variante in Kilogramm.
		</td>
	</tr>
	<tr>
		<td>
			Main color
		</td>
		<td>
			<b>Inhalt:</b> Die <b>Farbe</b>. Entsprechend des am Artikel hinterlegten Merkmals <b>main_color</b>.
		</td>
	</tr>
	<tr>
		<td>
			Gender
		</td>
		<td>
			<b>Inhalt:</b> Das <b>Geschlecht</b>. Entsprechend des am Artikel hinterlegten Merkmals <b>gender</b>.
		</td>
	</tr>
	<tr>
		<td>
			Type of public
		</td>
		<td>
			<b>Inhalt:</b> Die <b>Zielgruppe</b>. Entsprechend des am Artikel hinterlegten Merkmals <b>type_of_public</b>.
		</td>
	</tr>
	<tr>
		<td>
			Sports
		</td>
		<td>
			<b>Inhalt:</b> Entsprechend des am Artikel hinterlegten Merkmals <b>sports</b>.
		</td>
	</tr>
	<tr>
		<td>
			Comment
		</td>
		<td>
			<b>Inhalt:</b> Entsprechend des am Artikel hinterlegten Merkmals <b>comment</b>.
		</td>
	</tr>	
</table>

## 4 Licence
This project is licensed under the GNU AFFERO GENERAL PUBLIC LICENSE.- find further information in the [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-cdiscount-com/blob/master/LICENSE.md).
