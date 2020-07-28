@extends('layouts.app')

@section('content')
<main>
    <div class="wrapper">
        <div class="purchase">
            <div class="purchase-error">An error message.</div>

            <form>
                <h2>Kassa</h2>

                <p>Du har valt en <strong>"TICKET TYPE"</strong>-biljett för <strong>EVENT NAME</strong>. Det kommer att kosta <strong>XXX SEK</strong>.</p>

                <div class="modifiers">
                    <ul>
                        <li>
                            <input class="faux-radio-checkbox faux-checkbox" id='ID' value='SLUG' data-delta='DELTA' type="checkbox" />
                            <label for='ID' class="faux-radio-checkbox-label">
                                NAME <span>-100 SEK</span>
                            </label>
                        </li>
                    </ul>
                </div>

                <hr />

                <p>Vänligen skriv in din e-postadress som du vill att <strong>biljetten skickas till</strong>.</p>

                <input type="text" id="email" placeholder="Email" />

                <hr />

                <div class="nin-enter">
                    <p>Om du är medlem i LinTek, Consensus, eller Stuff kan du få kårrabatt. Mata in ditt personnummer nedan och tryck på verifiera för att få rabatten.</p>

                    <input type="text" id="nin" placeholder="Valfritt" />
                    <input type="button" id="nin-verify" class='added' value='Verifiera' />
                    <span class="smallprint">Skriv in ditt personnummer i formatet ÅÅMMDD-XXXX.</span>

                    <br style="clear: both;">

                    <hr />
                </div>

                <p>Vi behöver även lite mer info innan vi kan skicka din biljett till dig.</p>
                <input type="text" id="firstName" placeholder="Förnamn" />
                <input type="text" id="lastName" placeholder="Efternamn" />

                <br style="clear: both;">

                <p>CARD ELEMENT FROM STRIPE</p>

                <br style="clear: both;">

                <input id="terms" type="checkbox" /> <label htmlFor="terms">Jag godkänner dom <a href="/terms" target="_blank">allmänna villkoren</a>.</label>

                <br style="clear: both;">

                <input id="submit" type="submit" class="pink" value='Köp biljett för XXX SEK' />
                <span id="stripe-smallprint" class="smallprint">Köpet hanteras säkert genom <a href="https://stripe.com" target="_blank" rel="noopener noreferrer">Stripe</a> och dina<br /> kortuppgifter är aldrig tillgänliga för <a href="https://billio.app" target="_blank" rel="noopener noreferrer">Billio</a> eller <a href='' target="_blank" rel="noopener noreferrer">ORG NAME</a>.</span>

                <br style="clear: both;">
            </form>
        </div>
    </div>
</main>
@endsection
