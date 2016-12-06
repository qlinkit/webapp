<?php namespace Qlink\Models\Entities;         
/**
 * MIT License
 * Copyright (c) 2016 Lucas Mingarro, Ezequiel Alvarez, César Miquel, Ricardo Bianchi
 * https://opensource.org/licenses/MIT
 *
 * @author Ricardo Bianchi <rbianchi@qlink.it>
 */

use Jenssegers\Mongodb\Model as Eloquent;

class MongoQlinkMemory extends Eloquent {

    protected $collection = 'qlink_memory';
    protected $connection = 'qlink_mongodb';

}
