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
			Die Option <b>GTIN 13</b> wählen.
		</td>
	</tr>
    <tr>
        <td>
            Bild
        </td>
        <td>
            Die Option <b>Erstes Bild</b>wählen.
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


## 3 Overview of available columns

<table>
    <tr>
        <th>
            Column description
        </th>
        <th>
            Explanation
        </th>
    </tr>
    <tr>
    	<td>
    		Sku parent
    	</td>
    	<td>
    		<b>Required</b><br>
    		The <b>Parent SKU</b> of the variation.
    	</td>
    </tr>
    <tr>
    	<td>
    		Your reference
    	</td>
    	<td>
    		<b>Required</b><br>
    		The <b>SKU</b> of the variation. 
    	</td>
    </tr>
    <tr>
    	<td>
    		EAN
    	</td>
    	<td>
    		<b>Required</b><br>
			According to the format setting <b>Barcode</b>.
    	</td>
    </tr>
    <tr>
        <td>
            Brand
        </td>
        <td>
            <b>Required</b><br>
            The <b>name of the manufacturer</b> of the item. The <b>external name</b> within <b>Settings » Items » Manufacturer</b> will be preferred if existing.
        </td>
    </tr>
	<tr>
		<td>
			Nature of product
		</td>
		<td>
			<b>Required</b><br>
			The <b>product type</b> of a variation. This field defines wether a variation is a <b>single item</b> or a <b>variation of an item</b>.
		</td>
	</tr>
	<tr>
		<td>
			Category of product
		</td>
		<td>
			<b>Required</b><br>
			The <b>Category path of the standard category</b> for the <b>Client</b> configured in the format settings.
		</td>
	</tr>
	<tr>
		<td>
			Basket short wording
		</td>
		<td>
			<b>Required</b><br>
			Entsprechend der Formateinstellung <b>Artikelname</b>.
		</td>
	</tr>
	<tr>
    	<td>
    		Basket long wording
    	</td>
    	<td>
    		<b>Required</b><br>
    		According to the format setting <b>Preview text</b>.
    	</td>
    </tr>
	<tr>
    	<td>
    		Product description
    	</td>
    	<td>
    		<b>Required</b><br>
    		According to the format setting <b>Description</b>.
    	</td>
    </tr>
	<tr>
    	<td>
    		Picture 1 (jpeg)
    	</td>
    	<td>
    		<b>Required</b><br>
    		First image of a variation.
    	</td>
    </tr>
	<tr>
    	<td>
    		Size
    	</td>
    	<td>
    		The <b>size</b>. According to property <b>size</b> which is configured on the item.
    	</td>
    </tr>
	<tr>
    	<td>
    		Marketing color
    	</td>
    	<td>
    		The <b>color</b>. According to property <b>color</b> which is configured on the item.
    	</td>
    </tr>
	<tr>
    	<td>
    		Marketing description
    	</td>
    	<td>
    		The <b>Marketing description</b>. According to property <b>marketing_description</b> which is configured on the item.
    	</td>
    </tr>
	<tr>
    	<td>
    		Picture 2 (jpeg)
    	</td>
    	<td>
    		Second image of the variation.
    	</td>
    </tr>
	<tr>
    	<td>
			Picture 3 (jpeg)
		</td>
		<td>
			Third image of the variation.
		</td>
    </tr>
	<tr>
    	<td>
			Picture 4 (jpeg)
		</td>
		<td>
			Fourth image of the variation.
		</td>
    </tr>
    <tr>
		<td>
			ISBN / GTIN
		</td>
		<td>
			The <b>ISBN</b> of the variation.
		</td>
	</tr>
	<tr>
		<td>
			MFPN
		</td>
		<td>
			The <b>model</b> of the variation.
		</td>
	</tr>
	<tr>
		<td>
			Length
		</td>
		<td>
			The <b>length</b> of the variation in centimeters.
		</td>
	</tr>
	<tr>
		<td>
			Width
		</td>
		<td>
			The <b>width</b> of the variation in centimeters.
		</td>
	</tr>
	<tr>
		<td>
			Height
		</td>
		<td>
			The <b>height</b> of the variation in centimeters.
		</td>
	</tr>
	<tr>
		<td>
			Weight
		</td>
		<td>
			The <b>weight</b> of the variation in kilogram.
		</td>
	</tr>
	<tr>
		<td>
			Main color
		</td>
		<td>
			The <b>color</b>. According to property <b>main_color</b> which is configured on the item.
		</td>
	</tr>
	<tr>
		<td>
			Gender
		</td>
		<td>
			The <b>gender</b>. According to property <b>gender</b> which is configured on the item.
		</td>
	</tr>
	<tr>
		<td>
			Type of public
		</td>
		<td>
			The <b>target group</b>. According to property <b>type_of_public</b> which is configured on the item.
		</td>
	</tr>
	<tr>
		<td>
			Sports
		</td>
		<td>
			According to property <b>sports</b> which is configured on the item.
		</td>
	</tr>
	<tr>
		<td>
			Comment
		</td>
		<td>
			According to property <b>comment</b> which is configured on the item.
		</td>
	</tr>	
</table>

## 4 Licence

This project is licensed under the GNU AFFERO GENERAL PUBLIC LICENSE.- find further information in the [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-cdiscount-com/blob/master/LICENSE.md).
