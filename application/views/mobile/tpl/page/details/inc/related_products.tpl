[{block name="details_relatedproducts_similarproducts"}]
    [{if $oView->getSimilarProducts()|count}]
        [{capture append="oxidBlock_productbar" }]
            [{include file="widget/product/boxproducts.tpl" _boxId="similar"  _oBoxProducts=$oView->getSimilarProducts() _sHeaderIdent="SIMILAR_PRODUCTS" _sHeaderCssClass="lightHead"}]
        [{/capture}]
    [{/if}]
[{/block}]