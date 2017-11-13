<?php

namespace Portal\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Core\Models\User;

class GroupCreated implements ShouldBroadcast
{
	use InteractsWithSockets, SerializesModels;

	/**
	 * User that sent the message
	 *
	 * @var User
	 */
	public $user;

	/**
	 * Message details
	 *
	 * @var Message
	 */
	public $message;

	/**
	 * @var Bearer
	 */
	public $bearer;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, $message, $bearer)
	{
		$this->user = $user;
		$this->message = $message;
		$this->bearer = $bearer;
	}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return  new PrivateChannel('my-channel.'.substr($this->bearer, 0, 10));
    }
}
