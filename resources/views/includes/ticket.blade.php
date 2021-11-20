<div class='ticket'>
    <div class="qr">
        <img src="https://qrcode.tec-it.com/API/QRCode?quietzone=3&backcolor=fff&data={{$ticket[0]->ticket_code}}" />
    </div>

    <div class="ticket-preview-content">
        <h3>{{$ticket[0]->user->name}}</h3>
        <p>{{$ticket[0]->user->email}}</p>
    </div>

    <div class="ticket-preview-meta">
        <div class="ticket-preview-meta-item">
            <h4>Tillval</h4>
            <ul>
                <li>Tillvalsnamn</li>
                <li>Tillvalsnamn</li>
            </ul>
            <h4>Kod</h4>
            <span>{{$ticket[0]->ticket_code}}</span>
        </div>
    </div>
</div>

<br style="clear: both;" />
<br style="clear: both;" />
