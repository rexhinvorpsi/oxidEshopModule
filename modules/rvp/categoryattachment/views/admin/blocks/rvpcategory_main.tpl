[{$smarty.block.parent}]
<tr>
<td valign="top" class="edittext" align="left" width="55%" style="table-layout:fixed">

    <legend>[{ oxmultilang ident="ARTICLE_EXTEND_MEDIAURLS" }]</legend>
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

