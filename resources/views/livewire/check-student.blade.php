<div class="mt-2">
    <p>Om biljettmottagaren är medlem i LinTek, Consensus, eller Stuff kan hen få kårrabatt. Mata in hens personnummer nedan och tryck på verifiera för att få rabatten.</p>

    <div class="flex flex-row">
        <input type="text" id="nin" placeholder="Valfritt" wire:model="nin" class="focus:border-blue focus:ring-blue mr-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring focus:ring-opacity-50" />
        <input type="button" id="nin-verify" class='btn btn-blue' value={{$this->valid ? 'Valid' : 'Unvalid'}} wire:click="checkStudent" />
    </div>
    <span class="text-grey mt-2 inline-block text-sm">Skriv in ditt personnummer i formatet ÅÅMMDD-XXXX.</span>
</div>
