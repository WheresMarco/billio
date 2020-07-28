<div class="nin-enter">
    <p>Om du är medlem i LinTek, Consensus, eller Stuff kan du få kårrabatt. Mata in ditt personnummer nedan och tryck på verifiera för att få rabatten.</p>

    <input type="text" id="nin" placeholder="Valfritt" wire:model="nin" />
    <input type="button" id="nin-verify" class='added' value={{$this->valid ? 'Valid' : 'Unvalid'}} wire:click="checkStudent" />
    <span class="smallprint">Skriv in ditt personnummer i formatet ÅÅMMDD-XXXX.</span>

    <br style="clear: both;">

    <hr />
</div>
