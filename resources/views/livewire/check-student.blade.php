<div class="nin-enter">
    <p>Om biljettmottagaren är medlem i LinTek, Consensus, eller Stuff kan hen få kårrabatt. Mata in hens personnummer nedan och tryck på verifiera för att få rabatten.</p>

    <input type="text" id="nin" placeholder="Valfritt" wire:model="nin" />
    <input type="button" id="nin-verify" class='added' value={{$this->valid ? 'Valid' : 'Unvalid'}} wire:click="checkStudent" />
    <span class="smallprint">Skriv in ditt personnummer i formatet ÅÅMMDD-XXXX.</span>
</div>
