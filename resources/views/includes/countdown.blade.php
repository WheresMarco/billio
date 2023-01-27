<div class="mb-4 flex items-center rounded-md bg-gray-100 p-2" x-data="timer('{{$cart->first()->updated_at}}')" x-init="init();">
    <x-heroicon-o-clock class="mr-1 inline-block h-5" />
    <p>Vi har reserverat biljetterna i <strong x-text="time().minutes"></strong> minuter och <strong x-text="time().seconds"></strong> sekunder till.</p>
</div>

@push('scripts')
<script>
    function timer(expiry) {
            return {
                expiry: expiry,
                remaining: null,

                init() {
                    // Convert datetime to js date and add 10 minutes
                    this.expiry = new Date(this.expiry);
                    this.expiry.setMinutes(this.expiry.getMinutes() + 5);

                    this.setRemaining()
                    setInterval(() => {
                        this.setRemaining();
                    }, 1000);
                },

                setRemaining() {
                    // Get now date
                    const now = new Date();

                    const diff = this.expiry - new Date(now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate(), now.getUTCHours(), now.getUTCMinutes(), now.getUTCSeconds()).getTime();
                    this.remaining = parseInt(diff / 1000);

                    // If time is out redirect to event page
                    if (this.remaining <= 0) {
                        window.location.href = "/event/{{$event->slug}}";
                    }
                },

                days() {
                    return {
                        value:this.remaining / 86400,
                        remaining:this.remaining % 86400
                    };
                },

                hours() {
                    return {
                        value:this.days().remaining / 3600,
                        remaining:this.days().remaining % 3600
                    };
                },

                minutes() {
                    return {
                        value:this.hours().remaining / 60,
                        remaining:this.hours().remaining % 60
                    };
                },
                seconds() {
                    return {
                        value:this.minutes().remaining,
                    };
                },

                format(value) {
                    return ("0" + parseInt(value)).slice(-2)
                },

                time(){
                    return {
                        days:this.format(this.days().value),
                        hours:this.format(this.hours().value),
                        minutes:this.format(this.minutes().value),
                        seconds:this.format(this.seconds().value),
                    }
                },
            }
        }
</script>
@endpush
