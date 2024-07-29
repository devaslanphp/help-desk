<div>          
<div style="display: flex; flex-direction: row;" x-data="{activeTab: '{{ $notAssignedTickets->count() ? 'content1' : 'content2' }}'}">
                <div id="sidebar" style="left: 0px; top: 80px; margin: 0; padding: 0; width: 200px; background-color: #f1f1f1; position: fixed; height: 100%; overflow: auto;">
                    <a style="display: block; color: black; padding: 16px; text-decoration: none;">
                        <button @click="activeTab = 'content1'">Not assigned tickets</button>
                    </a>
                    <a style="display: block; color: black; padding: 16px; text-decoration: none;">
                        <button @click="activeTab = 'content2'">My assigned tickets</button>
                    </a>
                    <a style="display: block; color: black; padding: 16px; text-decoration: none;">
                        <button @click="activeTab = 'content3'">Tickets by statuses</button>
                    </a>
                    <a style="display: block; color: black; padding: 16px; text-decoration: none;">
                        <button @click="activeTab = 'content4'">Tickets assignments</button>
                    </a>
                    <a style="display: block; color: black; padding: 16px; text-decoration: none;">
                        <button @click="activeTab = 'content5'">Ticket Trends</button>
                    </a>
                </div>
                <div class="w-full flex flex-row flex-wrap ml-200" >
                    <div class="lg:w-full h-full flex flex-col">
                        
                        <div style="width: 250%; height: 100%;">
                            <!-- Content for Not assigned tickets -->
                            <div x-show="activeTab === 'content1'" id="content1" x-cloak style="flex: 1;">
                                @livewire('analytics.no-assigned-tickets')
                            </div>
                            <!-- Content for My assigned tickets -->
                            <div x-show="activeTab === 'content2'" id="content2" x-cloak style="flex: 1;">
                                @livewire('analytics.ticket-my-assigned-tickets')
                            </div>
                        </div>
                        <div x-show="activeTab === 'content3'" id="content3" x-cloak style="flex: 1;">
                            <!-- Content for Tickets by statuses -->
                            @livewire('analytics.ticket-statuses')
                        </div>
                        <div x-show="activeTab === 'content4'" id="content4" x-cloak style="flex: 1;">
                            <!-- Content for Tickets assignments -->
                            @livewire('analytics.ticket-assignments')
                        </div>
                        <div x-show="activeTab === 'content5'" id="content5" x-cloak style="flex: 1;">
                            <!-- Content for Ticket Trends -->
                            @livewire('analytics.ticket-trend')
                        </div>
                    </div>
                </div>
            </div>
    
    
            <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('tabs', () => ({
            activeTab: 'content1',
            init() {
                console.log(this.activeTab);
            }
        }))
    })
</script>       


    
</div>
