<?php

namespace App\Http\Livewire;

use App\Jobs\TicketCreatedJob;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketType;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\HtmlString;

class TicketsDialog extends Component implements HasForms
{
    use InteractsWithForms;

    public Ticket $ticket;
    public $category;
    public $content;
    public $subcategory;
    public $issueValue;

    public function mount(): void
    {
        $this->form->fill([
            'title' => $this->ticket->title,
            'content' => $this->ticket->content,
            'priority' => $this->ticket->priority,
        ]);
    }

    public function render()
    {
        return view('livewire.tickets-dialog');
    }

    public function setIssueValue($value)
    {
        $this->issueValue = $value;
    }

    /**
     * Form schema definition
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [

            Grid::make()
                ->schema([
                    Select::make('priority')
                        ->label(__('Priority'))
                        ->visible(fn ($get) => auth()->user()->hasRole('administrator'))
                        ->required()
                        ->searchable()
                        ->options(priorities_list()),

                    Select::make('category')
                        ->label(__('Category'))
                        ->required()
                        ->searchable()
                        ->options(categories_list('slug'))
                        ->reactive() // Ensures Livewire updates subcategory options when category changes
                        ->afterStateUpdated(function (callable $set, $get, $state) { //get gives slug
                            $set('subcategory', null);  // Reset subcategory when category changes
                            $set('issue', null);  // Reset issue when category changes
                        }), 
                    Select::make('subcategory')
                        ->label(__('Subcategory'))
                        ->required()
                        ->searchable()
                        ->reactive()
                        ->options(function ($get): array {
                            // Get all subcategories for the selected category
                            $subcategories = TicketCategory::getSubCategories($get('category'));
                            // Filter subcategories based on the user's role
                            if (!auth()->user()->hasRole('Human Resources')) {
                                // Remove 'createaccount' and 'userlocation' for non-HR users
                                $subcategories = array_filter($subcategories, function ($subcategory) {
                                    return !in_array($subcategory, ['createaccount', 'userlocation']);
                                },ARRAY_FILTER_USE_KEY);
                            }
                    
                            return $subcategories;
                        })
                        ->afterStateUpdated(function (callable $set, $get, $state) { //state gives slug 
                            if($get('subcategory') != null){
                                $set('category', TicketCategory::getChosenCategory($state));
                            }
                            $set('issue', null);
                            if($state == ('networkaccessright' || 'createaccount' || 'userlocation')){
                                $this->setIssueValue($state);
                            }
                    }), // Set category when categories changes
                    Select::make('issue')
                        ->label(__('Issue'))
                        ->required(function ($get): bool { 
                            $subcategory = $get('subcategory');
                            return !in_array($subcategory, ['networkaccessright', 'createaccount','userlocation']);
                        })
                        ->hidden(function ($get): bool { 
                            $subcategory = $get('subcategory');
                            return in_array($subcategory, ['networkaccessright', 'createaccount','userlocation']);
                        })
                        ->searchable()
                        ->reactive()
                        ->options(function ($get): array {
                            if($get('category') != null && $get('subcategory') == null)
                            $arrayIssues = TicketCategory::getIssuesByCategory($get('category'));
                            else
                            $arrayIssues = TicketCategory::getIssues($get('subcategory'));
                    
                            return $arrayIssues;
                        })
                        ->afterStateUpdated(function (callable $set, $get, $state) { //state gives slug 
                            if($get('issue') != null){
                                $set('subcategory', TicketCategory::getChosenCategory($state));
                                $set('category', TicketCategory::getChosenCategory($get('subcategory')));
                                $this->setIssueValue(null);
                            }
                    }),
                ]),
            Section::make('Network Access Right')
                ->description(fn () => new HtmlString('<span style="color: #FF0000;">Need approval from HOD department</span><br>Detail User:'), 'above')
                ->schema([
                    Grid::make()
                        ->schema([
                            TextInput::make('department')
                                ->label(__('Department (With Floor):'))
                                ->required(fn ($get) => $get('subcategory') === 'networkaccessright')
                                ->maxLength(255)
                                ->required(),

                            TextInput::make('requestforaccess')
                                ->label(__('Reason? (Social Media, Streaming Services & etc):'))
                                ->required(fn ($get) => $get('subcategory') === 'networkaccessright')
                                ->maxLength(255)
                                ->required(),
                        ]),
                ])
                ->collapsible()
                ->visible((fn ($get) => $get('subcategory') === 'networkaccessright')),

            Section::make('Create New Account & Computer Installation')
                ->schema([
                    Grid::make()
                        ->schema([
                            TextInput::make('name')
                                ->label(__('Name:'))
                                ->required(fn ($get) => $get('subcategory') === 'createaccount')
                                ->maxLength(255)
                                ->required(),
                            
                            TextInput::make('staffid')
                                ->label(__('Staff ID:'))
                                ->required(fn ($get) => $get('subcategory') === 'createaccount')
                                ->maxLength(255)
                                ->required(),
                            
                            TextInput::make('mykad')
                                ->label(__('MyKad:'))
                                ->required(fn ($get) => $get('subcategory') === 'createaccount')
                                ->maxLength(255)
                                ->required(),
                            
                            TextInput::make('position')
                                ->label(__('Position / Gred:'))
                                ->required(fn ($get) => $get('subcategory') === 'createaccount')
                                ->maxLength(255)
                                ->required(),
                            
                            TextInput::make('department')
                                ->label(__('Department:'))
                                ->required(fn ($get) => $get('subcategory') === 'createaccount')
                                ->maxLength(255)
                                ->required(),
                            
                            TextInput::make('pcinstallationlocation')
                                ->label(__('PC Installation Location (With Department & Floor):'))
                                ->required(fn ($get) => $get('subcategory') === 'createaccount')
                                ->maxLength(255)
                                ->required(),
                        ]),
                ])
                ->collapsible()
                ->visible((fn ($get) => $get('subcategory') === 'createaccount')),


            Section::make('Previous User & Location Details')
                ->schema([
                    Grid::make()
                        ->schema([
                            TextInput::make('previousname')
                                ->label(__('Name:'))
                                ->required(fn ($get) => $get('subcategory') === 'userlocation')
                                ->maxLength(255)
                                ->required(),
                            
                            TextInput::make('previousstaffid')
                                ->label(__('Staff ID:'))
                                ->required(fn ($get) => $get('subcategory') === 'userlocation')
                                ->maxLength(255)
                                ->required(),
                            
                            TextInput::make('previousmykad')
                                ->label(__('MyKad:'))
                                ->required(fn ($get) => $get('subcategory') === 'userlocation')
                                ->maxLength(255)
                                ->required(),
                            
                            TextInput::make('previousposition')
                                ->label(__('Position / Gred:'))
                                ->required(fn ($get) => $get('subcategory') === 'userlocation')
                                ->maxLength(255)
                                ->required(),
                            
                            TextInput::make('previousdepartment')
                                ->label(__('Department & Floor:'))
                                ->required(fn ($get) => $get('subcategory') === 'userlocation')
                                ->maxLength(255)
                                ->required(),
                        ]),
                ])
                ->collapsible()
                ->visible((fn ($get) => $get('subcategory') === 'userlocation')),
            Section::make('Current User Details')
                ->schema([
                    Grid::make()
                        ->schema([
                            TextInput::make('currentstaffid')
                                ->label(__('Staff ID:'))
                                ->required(fn ($get) => $get('subcategory') === 'userlocation')
                                ->maxLength(255)
                                ->required(),

                            TextInput::make('currentposition')
                                ->label(__('Position / Gred:'))
                                ->required(fn ($get) => $get('subcategory') === 'userlocation')
                                ->maxLength(255)
                                ->required(),
                            
                            TextInput::make('currentdepartment')
                                ->label(__('Department & Floor:'))
                                ->required(fn ($get) => $get('subcategory') === 'userlocation')
                                ->maxLength(255)
                                ->required(),
                        ]),
                ])
                ->collapsible()
                ->visible((fn ($get) => $get('subcategory') === 'userlocation')),

            Section::make('New Location Details (Computer Installation)')
                ->schema([
                    Grid::make()
                        ->schema([
                            TextInput::make('installationlocation')
                                ->label(__('Installation Location (with Department & Floor):'))
                                ->required(fn ($get) => $get('subcategory') === 'userlocation')
                                ->maxLength(255)
                                ->required(),
                    ]),
                ])
                ->collapsible()
                ->visible((fn ($get) => $get('subcategory') === 'userlocation')),

            TextInput::make('title')
                ->label(__('Ticket title'))
                ->maxLength(255)
                ->required(),

            RichEditor::make('content')
                ->label(__('Content'))
                ->fileAttachmentsDisk(config('filesystems.default'))
                ->fileAttachmentsDirectory('tickets')
                ->fileAttachmentsVisibility('private'),
        ];
    }

    /**
     * Create / Update the ticket
     *
     * @return void
     */
    public function save(): void
    {
        $data = $this->form->getState();
        $content = "";
        if($data['subcategory'] == 'networkaccessright'){
            $department = $data['department' ?? null];
            $requestforaccess = $data['requestforaccess' ?? null];
            $content = "<u>Detail User</u><br><b>Department (With Floor):</b> $department<br><b>Request for Access? (Social Media, Streaming Services & etc):</b> $requestforaccess";
        }
        if($data['subcategory'] == 'createaccount'){
            $name = $data['name'] ?? null;
            $staffid = $data['staffid' ?? null];
            $mykad = $data['mykad' ?? null];
            $position = $data['position' ?? null];
            $department = $data['department' ?? null];
            $pcinstallationlocation = $data['pcinstallationlocation' ?? null];
            $content = "<b>Name:</b> $name<br><b>Staff ID:</b> $staffid<br><b>MyKad:</b> $mykad<br><b>Position / Gred:</b> $position<br><b>Department:</b> $department<br><b>PC Installation Location (With Department & Floor):</b> $pcinstallationlocation";
        }
        if($data['subcategory'] == 'userlocation'){
            $content .= "Previous User & Location Details<br>";
            $previousname = $data['previousname'] ?? null;
            $previousstaffid = $data['previousstaffid' ?? null];
            $previousmykad = $data['previousmykad' ?? null];
            $previousposition = $data['previousposition' ?? null];
            $previousdepartment = $data['previousdepartment' ?? null];
            $content = "<b>Name:</b> $previousname<br><b>Staff ID:</b> $previousstaffid<br><b>MyKad:</b> $previousmykad<br><b>Position / Gred:</b> $previousposition<br><b>Department & Floor:</b> $previousdepartment<br>";
        
            $content .= "Current User Details<br>";
            $currentstaffid = $data['currentstaffid'] ?? null;
            $currentposition = $data['currentposition' ?? null];
            $currentdepartment = $data['currentdepartment' ?? null];
            $content = "<b>Staff ID:</b> $currentstaffid<br><b>Position / Gred:</b> $currentposition<br><b>Department & Floor:</b> $currentdepartment<br>";
        
            $content .= "New Location Details (Computer Installation)<br>";
            $installationlocation = $data['installationlocation' ?? null];
            $content .= "<b>Installation Location (with Department & Floor):</b> $installationlocation";

        }
        $content .= $data['content'];
        if($this->issueValue == null){
        $ticket = Ticket::create([
            'title' => $data['title'],
            'content' => $content,
            'owner_id' => auth()->user()->id,
            'priority' => $data['priority'] ?? null,
            'category' => $data['category'],
            'subcategory' => $data['subcategory'],
            'issue' => $data['issue'],
            'type' => TicketCategory::where('slug',$data['issue'] ?? $data['subcategory'])->pluck('type')->first(),
            'status' => default_ticket_status()
        ]);
        }else{
            $ticket = Ticket::create([
                'title' => $data['title'],
                'content' => $content,
                'owner_id' => auth()->user()->id,
                'priority' => $data['priority'] ?? null,
                'category' => $data['category'],
                'subcategory' => $data['subcategory'],
                'issue' => $this->issueValue,
                'type' => TicketCategory::where('slug',$data['issue'] ?? $data['subcategory'])->pluck('type')->first(),
                'status' => default_ticket_status()
            ]);
        }
        Notification::make()
            ->success()
            ->title(__('Ticket created'))
            ->body(__('The ticket has been successfully created'))
            ->actions([
                Action::make('redirect')
                    ->label(__('See details'))
                    ->color('success')
                    ->button()
                    ->close()
                    ->url(fn() => route('tickets.details', [
                        'ticket' => $ticket,
                        'slug' => Str::slug($ticket->title)
                    ]))
            ])
            ->send();
        $this->emit('ticketSaved');
        TicketCreatedJob::dispatch($ticket);
    }
}
