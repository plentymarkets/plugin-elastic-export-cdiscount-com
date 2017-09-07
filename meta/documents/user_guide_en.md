# ElasticExportCdiscountCOM plugin user guide

<div class="container-toc"></div>

## 1 Registering with Cdiscount.com

Items are sold on the market Cdiscount. For further information about this market, refer to the [Setting up cdiscount](https://knowledge.plentymarkets.com/en/omni-channel/multi-channel/cdiscount) page of the manual.

## 2 Setting up the data format CdiscountCOM-Plugin in plentymarkets

To use this format, you need the Elastic Export plugin.

Refer to the [Exporting data formats for price search engines](https://knowledge.plentymarkets.com/en/basics/data-exchange/exporting-data#30) page of the manual for further details about the individual format settings.

The following table lists details for settings, format settings and recommended item filters for the format **CdiscountCOM-Plugin**.
<table>
    <tr>
        <th>
            Settings
        </th>
        <th>
            Explanation
        </th>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Settings
        </td>
    </tr>
    <tr>
        <td>
            Format
        </td>
        <td>
            Choose <b>CdiscountCOM-Plugin</b>.
        </td>
    </tr>
    <tr>
        <td>
            Provisioning
        </td>
        <td>
            <b>URL</b> wählen.
        </td>
    </tr>
    <tr>
        <td>
            File name
        </td>
        <td>
            The file name must have the ending <b>.csv</b> for Cdiscount.com to be able to import the file successfully.
        </td>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Item filter
        </td>
    </tr>
    <tr>
        <td>
            Activ
        </td>
        <td>
            Choose <b>Activ</b>.
        </td>
    </tr>
    <tr>
        <td>
            Markets
        </td>
        <td>
            Choose <b>Cdiscount.com</b>.
        </td>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Format settings
        </td>
    </tr>
    <tr>
        <td>
            Order referrer
        </td>
        <td>
            Choose <b>Cdiscount.com</b>.
        </td>
    </tr>
    <tr>
        <td>
            Preview text
        </td>
        <td>
            This option does not affect this format.
        </td>
    </tr>
    <tr>
		<td>
			Barcode
		</td>
		<td>
			Choose the option <b>GTIN 13</b>.
		</td>
	</tr>
    <tr>
        <td>
            Image
        </td>
        <td>
            Choose the option <b>First image</b>.
        </td>
    </tr>
    <tr>
		<td>
			Image position of the energy label
		</td>
		<td>
			This option does not affect this format.
		</td>
	</tr>
    <tr>
        <td>
            Special price
        </td>
        <td>
            This option does not affect this format.
        </td>
    </tr>
    <tr>
		<td>
			RRP
		</td>
		<td>
			This option does not affect this format.
		</td>
	</tr>
	<tr>
		<td>
			Shipping cost
		</td>
		<td>
			This option does not affect this format.
		</td>
	</tr>
    <tr>
        <td>
            VAT note
        </td>
        <td>
            This option does not affect this format.
        </td>
    </tr>
    <tr>
		<td>
			Override item availabilty
		</td>
		<td>
			This option does not affect this format.
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
