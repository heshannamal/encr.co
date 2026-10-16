<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerEnquiryItemsDetail extends Model
{
    use HasFactory;
    protected $table = 'customer_enquiry_items_details';
    protected $fillable = [
        'qty', 'size_id', 'blanks', 'numseq_one', 'numseq_two', 'numseq_three', 'numseq_four', 'numseq_five', 'numseq_six', 'numseq_seven', 'numseq_eight',
        'numseq_nine', 'numseq_ten', 'numseq_eleven', 'numseq_twelve', 'numseq_thirteen', 'numseq_fourteen', 'numseq_fifteen', 'numseq_sixteen',
        'numseq_seventeen', 'numseq_eighteen', 'numseq_nineteen', 'numseq_twenty', 'numseq_twenty_one', 'numseq_twenty_two', 'numseq_twenty_three',
        'numseq_twenty_four', 'numseq_twenty_five', 'numseq_twenty_six', 'numseq_twenty_seven', 'numseq_twenty_eight', 'numseq_twenty_nine', 'numseq_thirty',
        'numseq_thirty_one', 'numseq_thirty_two', 'numseq_thirty_three', 'numseq_thirty_four', 'numseq_thirty_five', 'numseq_thirty_six', 'numseq_thirty_seven',
        'numseq_thirty_eight', 'numseq_thirty_nine', 'numseq_forty', 'numseq_forty_one', 'numseq_forty_two', 'numseq_forty_three', 'numseq_forty_four',
        'numseq_forty_five', 'numseq_forty_six', 'numseq_forty_seven', 'numseq_forty_eight', 'numseq_forty_nine', 'numseq_fifty', 'show_extra'
    ];
}
