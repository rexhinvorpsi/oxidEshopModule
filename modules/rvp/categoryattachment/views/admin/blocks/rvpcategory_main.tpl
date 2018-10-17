
[{$smarty.block.parent}]
<tr>
<td valign="top" class="edittext" align="left" width="55%" style="table-layout:fixed">

    <legend><b>[{ oxmultilang ident="CATEGORY_EXTEND_MEDIAURL" }]</b></legend>
    <table cellspacing="0" cellpadding="0" border="0">

        [{foreach from=$aMediaUrls item=oMediaUrl}]
        <tr>
            [{if $oddclass == 2}]
            [{assign var=oddclass value=""}]
            [{else}]
            [{assign var=oddclass value="2"}]
            [{/if}]
            <td class=listitem[{$oddclass}]>
                &nbsp;<a href="[{ $oMediaUrl->getLink() }]" target="_blank">&raquo;&raquo;</a>&nbsp;
            </td>
            <td class=listitem[{$oddclass}]>
                &nbsp;<a href="[{$oViewConf->getSelfLink()}]&cl=article_extend&amp;mediaid=[{$oMediaUrl->oxmediaurls__oxid->value}]&amp;fnc=deletemedia&amp;oxid=[{$oxid}]&amp;editlanguage=[{ $editlanguage }]" onClick='return confirm("[{ oxmultilang ident="GENERAL_YOUWANTTODELETE" }]")'><img src="[{$oViewConf->getImageUrl()}]/delete_button.gif" border=0></a>&nbsp;
            </td>
            <td class="listitem[{$oddclass}]" width=250>
                <input style="width:100%" class="edittext" type="text" name="aMediaUrls[[{ $oMediaUrl->oxmediaurls__oxid->value }]][oxmediaurls__oxdesc]" value="[{ $oMediaUrl->oxmediaurls__oxdesc->value }]">
            </td>
        </tr>
        [{/foreach}]

        [{if $aMediaUrls->count()}]
        <tr>
            <td colspan="3" align="right">
                <input class="edittext" type="button" onclick="this.form.fnc.value='updateMedia';this.form.submit();" [{$readonly}] value="[{ oxmultilang ident="ARTICLE_EXTEND_UPDATEMEDIA" }]">
                <br><br>
            </td>
        </tr>
        [{/if}]

        <tr>
            <td colspan="3">
                [{ oxmultilang ident="ARTICLE_EXTEND_DESCRIPTION" }]:<br>
                <input style="width:100%" type="text" name="mediaDesc" class="edittext" [{$readonly}]>
            </td>
        </tr>

        <tr>
            <td colspan="3">
                [{ oxmultilang ident="ARTICLE_EXTEND_ENTERURL" }]:<br>
                <input style="width:100%" type="text" name="mediaUrl" class="edittext" [{$readonly}]>
            </td>
        </tr>

        <tr>
            <td colspan="3">
                [{ oxmultilang ident="ARTICLE_EXTEND_UPLOADFILE" }]:<br>
                <input style="width:100%" type="file" name="mediaFile" class="edittext" [{$readonly}]>
            </td>
        </tr>
    </table>

