<form class="pkp_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="submissionId" value="{$submissionId}" />
    <label for="graphicalAbstractFile">{translate key="plugins.generic.graphicalAbstract.uploadLabel"}</label>
    <input type="file" name="graphicalAbstractFile" accept="image/*">
    {if $graphicalAbstractUrl}
        <p>{translate key="plugins.generic.graphicalAbstract.currentImage"}</p>
        <img src="{$graphicalAbstractUrl}" style="max-width:200px;">
    {/if}
    <button class="pkp_button">{translate key="plugins.generic.graphicalAbstract.save"}</button>
</form>
