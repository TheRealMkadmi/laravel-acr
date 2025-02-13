<?php

namespace TheRealMkadmi\LaravelAcr\Transport;

use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\MessageConverter;
use TheRealMkadmi\LaravelAcr\AzureCommunicationClient;

class AzureMailTransport extends AbstractTransport
{
    protected AzureCommunicationClient $client;

    /**
     * Create a new AzureMailTransport instance.
     */
    public function __construct(AzureCommunicationClient $client, ?LoggerInterface $logger = null)
    {
        parent::__construct($logger);
        $this->client = $client;
    }

    /**
     * Sends the email using Azure Communication Services.
     *
     *
     *
     * @throws \Exception
     */
    protected function doSend(SentMessage $message): void
    {
        // Convert the Symfony message to an Email instance.
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        // Prepare the email payload for Azure Communication Services.
        $emailData = $this->prepareEmailData($email);

        // Send the email via Azure Communication Services.
        $this->client->sendEmail($emailData);

        // Optionally, set the message ID for tracking.
        $message->setMessageId('<azure-'.uniqid().'@example.com>');
    }

    /**
     * Prepare the email payload from a Symfony Email instance.
     */
    protected function prepareEmailData(Email $email): array
    {
        // Determine the sender address.
        $fromAddresses = $email->getFrom();
        $from = count($fromAddresses) > 0 ? $fromAddresses[0]->getAddress() : config('azuremail.sender');

        // Format the recipients.
        $to = $this->formatAddressArray($email->getTo());
        $cc = $this->formatAddressArray($email->getCc());
        $bcc = $this->formatAddressArray($email->getBcc());

        // Retrieve subject.
        $subject = $email->getSubject();

        // Retrieve email body content.
        $htmlBody = $email->getHtmlBody();
        $plainTextBody = $email->getTextBody();

        if (! $plainTextBody && $htmlBody) {
            $plainTextBody = strip_tags($htmlBody);
        }

        $emailData = [
            'senderAddress' => $from,
            'content' => [
                'subject' => $subject,
                'html' => $htmlBody,
                'plainText' => $plainTextBody,
            ],
            'recipients' => [
                'to' => $to,
            ],
        ];

        if (! empty($cc)) {
            $emailData['recipients']['cc'] = $cc;
        }
        if (! empty($bcc)) {
            $emailData['recipients']['bcc'] = $bcc;
        }

        return $emailData;
    }

    /**
     * Format an iterable of addresses into the expected Azure format.
     */
    protected function formatAddressArray(?iterable $addresses): array
    {
        $formatted = [];
        if ($addresses !== null) {
            foreach ($addresses as $address) {
                if ($address instanceof \Symfony\Component\Mime\Address) {
                    $formatted[] = [
                        'address' => $address->getAddress(),
                        'displayName' => $address->getName(),
                    ];
                }
            }
        }

        return $formatted;
    }

    /**
     * Return a string representation of the transport.
     */
    public function __toString(): string
    {
        return 'azure';
    }
}
