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
