<?

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

class DomainResource extends JsonResource{

	/**
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array{
		return [
			'domainName' => idn_to_utf8($this->domain_name_ascii),
			'dnsA' => $this->dnsRecordsA()->get(['content', 'hostname']),
			'dnsMX' => $this->dnsRecordsMX()->get(['content, hostname']),
			'httpData' => $this->httpData()->first(['header', 'response_code', 'title']),
			'htmlMetaData' => $this->htmlMetaData()->get(['meta_name', 'meta_content', 'meta_charset', 'meta_http_equiv', 'meta_property', 'meta_itemprop']),
			'updateAge' => [
				'updateAgeDnsA' => (Date::now()->unix() - ($this->dnsRecordsA->first()?->updated_at->unix() ?? Date::now()->unix())),
				'updateAgeDnsMx' => (Date::now()->unix() - ($this->dnsRecordsMX->first()?->updated_at->unix() ?? Date::now()->unix())),
				'updateAgeHttp' => (Date::now()->unix() - ($this->httpData()?->first()?->updated_at->unix() ?? Date::now()->unix())),
				'updateAgeHtml' => (Date::now()->unix() - ($this->htmlMetaData()?->get()?->first()?->updated_at->unix() ?? Date::now()->unix())),
			],
		];
	}
}
