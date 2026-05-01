<?php

namespace App\Livewire\Forms;

use App\Models\Ticket;
use Livewire\Component;

class EditTicket extends Component
{
    public $ticketId;
    public $title;
    public $priority;
    public $status;

    protected $rules = [
        'title' => 'required|string|max:255',
        'priority' => 'required|string|in:low,medium,high',
        'status' => 'required|string|in:open,closed,pending',
    ];

    public function mount($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $this->ticketId = $ticket->id;
        $this->title = $ticket->title;
        $this->priority = $ticket->priority;
        $this->status = $ticket->status;
    }

    public function updateTicket()
    {
        $this->validate();

        $ticket = Ticket::findOrFail($this->ticketId);
        $ticket->update([
            'title' => $this->title,
            'priority' => $this->priority,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Ticket updated successfully!');
        return redirect()->route('ticket.show', ['ticket' => $this->ticketId]); // Redirect to the ticket detail view
    }

    public function render()
    {
        return view('livewire.edit-ticket');
    }
}
