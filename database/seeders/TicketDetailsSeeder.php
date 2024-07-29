<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Notice;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TicketDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Ticket priorities
        DB::table('ticket_priorities')->insert(
            array(
                'title' => 'Low',
                'text_color' => '#000000',
                'bg_color' => '#d4edda',
                'icon' => 'fa-1 ',
                'slug' => 'low',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_priorities')->insert(
            array(
                'title' => 'Medium',
                'text_color' => '#000000',
                'bg_color' => '#fff3cd',
                'icon' => 'fa-2',
                'slug' => 'medium',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_priorities')->insert(
            array(
                'title' => 'High',
                'text_color' => '#ffffff',
                'bg_color' => '#fd7e14',
                'icon' => 'fa-3',
                'slug' => 'high',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_priorities')->insert(
            array(
                'title' => 'Critical',
                'text_color' => '#ffffff',
                'bg_color' => '#721c24',
                'icon' => 'fa-exclamation',
                'slug' => 'critical',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        //Ticket statuses
        DB::table('ticket_statuses')->insert(
            array(
                'title' => 'Open',
                'text_color' => '#ffffff',
                'bg_color' => '#c2c9c7',
                'default' => 1,
                'slug' => 'open',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        //Ticket statuses
        DB::table('ticket_statuses')->insert(
            array(
                'title' => 'Pending',
                'text_color' => '#ffffff',
                'bg_color' => '#ff3342',
                'default' => 0,
                'slug' => 'pending',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_statuses')->insert(
            array(
                'title' => 'In Progress',
                'text_color' => '#ffffff',
                'bg_color' => '#ffd133',
                'default' => 0,
                'slug' => 'inprogress',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_statuses')->insert(
            array(
                'title' => 'Resolved',
                'text_color' => '#ffffff',
                'bg_color' => '#33ff7a',
                'default' => 0,
                'slug' => 'resolved',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_statuses')->insert(
            array(
                'title' => 'Closed',
                'text_color' => '#ffffff',
                'bg_color' => '#343a40',
                'default' => 0,
                'slug' => 'closed',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_statuses')->insert(
            array(
                'title' => 'Approved',
                'text_color' => '#ffffff',
                'bg_color' => '#1589D1',
                'default' => 0,
                'slug' => 'approved',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_statuses')->insert(
            array(
                'title' => 'Disapproved',
                'text_color' => '#ffffff',
                'bg_color' => '#E86A22',
                'default' => 0,
                'slug' => 'disapproved',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        //Ticket types
        DB::table('ticket_types')->insert(
            array(
                'title' => 'Incident',
                'text_color' => '#ffffff',
                'bg_color' => '#dc3545',
                'icon' => 'fa-exclamation',
                'slug' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_types')->insert(
            array(
                'title' => 'Service Request',
                'text_color' => '#ffffff',
                'bg_color' => '#007bff',
                'icon' => 'fa-solid fa-screwdriver-wrench',
                'slug' => 'servicerequest',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_types')->insert(
            array(
                'title' => 'Change Request',
                'text_color' => '#ffffff',
                'bg_color' => '#fd7e14',
                'icon' => 'fa-solid fa-arrows-rotate',
                'slug' => 'changerequest',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 1
            array(
                'title' => 'Hardware',
                'parent_id' => null,
                'text_color' => '#ffffff',
                'bg_color' => '#28a745',
                'slug' => 'hardware',
                'level' => 'category',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 2
            array(
                'title' => 'SFF / AIO / Laptop',
                'text_color' => '#ffffff',
                'bg_color' => '#28a745',
                'parent_id' => 1,
                'slug' => 'pc',
                'level' => 'subcategory',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 3
            array(
                'title' => 'PC Repair or Replacement',
                'text_color' => '#ffffff',
                'bg_color' => '#28a745',
                'parent_id' => 2,
                'slug' => 'repairpc',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 4
            array(
                'title' => 'Peripheral Issues (Keyboard, Mouse, Monitor)',
                'text_color' => '#ffffff',
                'bg_color' => '#28a745',
                'parent_id' => 2,
                'slug' => 'peripheral',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 5
            array(
                'title' => 'Printers and Scanners',
                'text_color' => '#ffffff',
                'bg_color' => '#28a745',
                'parent_id' => 1,
                'slug' => 'printer',
                'level' => 'subcategory',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 6
            array(
                'title' => 'Setup or Configuration',
                'text_color' => '#ffffff',
                'bg_color' => '#28a745',
                'parent_id' => 5,
                'slug' => 'setupprinter',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 7
            array(
                'title' => 'Printer/Scanner Repair or Replacement',
                'text_color' => '#ffffff',
                'bg_color' => '#28a745',
                'parent_id' => 5,
                'slug' => 'repairprinter',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 8
            array(
                'title' => 'Connectivity Issues',
                'text_color' => '#ffffff',
                'bg_color' => '#28a745',
                'parent_id' => 5,
                'slug' => 'printerconnectivity',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 9
            array(
                'title' => 'Printing Quality Problems',
                'text_color' => '#ffffff',
                'bg_color' => '#28a745',
                'parent_id' => 5,
                'slug' => 'printerquality',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 10
            array(
                'title' => 'Software',
                'parent_id' => null,
                'text_color' => '#ffffff',
                'bg_color' => '#aaa233',
                'slug' => 'software',
                'level' => 'category',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 11
            array(
                'title' => 'Operating Systems',
                'text_color' => '#ffffff',
                'bg_color' => '#aaa233',
                'parent_id' => 10,
                'slug' => 'os',
                'level' => 'subcategory',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 12
            array(
                'title' => 'OS Installation or Upgrade',
                'text_color' => '#ffffff',
                'bg_color' => '#aaa233',
                'parent_id' => 11,
                'slug' => 'installos',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 13
            array(
                'title' => 'OS Performance Issues',
                'text_color' => '#ffffff',
                'bg_color' => '#aaa233',
                'parent_id' => 11,
                'slug' => 'osperformance',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );


        DB::table('ticket_categories')->insert(// 14
            array(
                'title' => 'Applications',
                'text_color' => '#ffffff',
                'bg_color' => '#aaa233',
                'parent_id' => 10,
                'slug' => 'apps',
                'level' => 'subcategory',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 15
            array(
                'title' => 'Application Installation or Upgrade',
                'text_color' => '#ffffff',
                'bg_color' => '#aaa233',
                'parent_id' => 14,
                'slug' => 'appinstall',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 16
            array(
                'title' => 'Licensing Issues',
                'text_color' => '#ffffff',
                'bg_color' => '#aaa233',
                'parent_id' => 14,
                'slug' => 'applicense',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 17
            array(
                'title' => 'Functionality Problems',
                'text_color' => '#ffffff',
                'bg_color' => '#aaa233',
                'parent_id' => 14,
                'slug' => 'appfunction',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 18
            array(
                'title' => 'Email',
                'text_color' => '#ffffff',
                'bg_color' => '#aaa233',
                'parent_id' => 10,
                'slug' => 'email',
                'level' => 'subcategory',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 19
            array(
                'title' => 'Mailbox Quotas',
                'text_color' => '#ffffff',
                'bg_color' => '#aaa233',
                'parent_id' => 18,
                'slug' => 'emailquota',
                'level' => 'issue',
                'type' => 'changerequest',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 20
            array(
                'title' => 'Email Performance Issues',
                'text_color' => '#ffffff',
                'bg_color' => '#aaa233',
                'parent_id' => 18,
                'slug' => 'emailperformance',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 21
            array(
                'title' => 'Connectivity Problems',
                'text_color' => '#ffffff',
                'bg_color' => '#aaa233',
                'parent_id' => 18,
                'slug' => 'emailconnectivity',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 22
            array(
                'title' => 'Setup Account Mobile',
                'text_color' => '#ffffff',
                'bg_color' => '#aaa233',
                'parent_id' => 18,
                'slug' => 'emailsetup',
                'level' => 'issue',
                'type' => 'servicerequest',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 23
            array(
                'title' => 'Network',
                'text_color' => '#ffffff',
                'bg_color' => '#ccc233',
                'parent_id' => null,
                'slug' => 'network',
                'level' => 'category',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 24
            array(
                'title' => 'Connectivity',
                'text_color' => '#ffffff',
                'bg_color' => '#ccc233',
                'parent_id' => 23,
                'slug' => 'connectivity',
                'level' => 'subcategory',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 25
            array(
                'title' => 'Wired/Wireless Access Issues',
                'text_color' => '#ffffff',
                'bg_color' => '#ccc233',
                'parent_id' => 24,
                'slug' => 'networkaccess',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 26
            array(
                'title' => 'VPN Connectivity Problems',
                'text_color' => '#ffffff',
                'bg_color' => '#ccc233',
                'parent_id' => 24,
                'slug' => 'vpnconnectivity',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 27
            array(
                'title' => 'VPN - Request Configuration',
                'text_color' => '#ffffff',
                'bg_color' => '#ccc233',
                'parent_id' => 24,
                'slug' => 'vpnconfigure',
                'level' => 'issue',
                'type' => 'servicerequest',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 28
            array(
                'title' => 'Network Performance',
                'text_color' => '#ffffff',
                'bg_color' => '#ccc233',
                'parent_id' => 24,
                'slug' => 'networkperformance',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );


        DB::table('ticket_categories')->insert(// 29
            array(
                'title' => 'Security',
                'text_color' => '#ffffff',
                'bg_color' => '#ccc233',
                'parent_id' => 23,
                'slug' => 'security',
                'level' => 'subcategory',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 30
            array(
                'title' => 'Firewall Issues',
                'text_color' => '#ffffff',
                'bg_color' => '#ccc233',
                'parent_id' => 29,
                'slug' => 'firewall',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 31
            array(
                'title' => 'Virus Attack',
                'text_color' => '#ffffff',
                'bg_color' => '#ccc233',
                'parent_id' => 29,
                'slug' => 'virus',
                'level' => 'issue',
                'type' => 'incident',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 32
            array(
                'title' => 'Accounts and Access',
                'text_color' => '#ffffff',
                'bg_color' => '#bbb444',
                'parent_id' => null,
                'slug' => 'accountaccess',
                'level' => 'category',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 33
            array(
                'title' => 'User Accounts',
                'text_color' => '#ffffff',
                'bg_color' => '#bbb444',
                'parent_id' => 32,
                'slug' => 'useraccount',
                'level' => 'subcategory',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 34
            array(
                'title' => 'Password Resets',
                'text_color' => '#ffffff',
                'bg_color' => '#bbb444',
                'parent_id' => 33,
                'slug' => 'passwordreset',
                'level' => 'issue',
                'type' => 'changerequest',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 35
            array(
                'title' => 'e-Cloud MyIPO',
                'text_color' => '#ffffff',
                'bg_color' => '#bbb444',
                'parent_id' => 32,
                'slug' => 'ecloud',
                'level' => 'subcategory',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 36
            array(
                'title' => 'Unblock Account',
                'text_color' => '#ffffff',
                'bg_color' => '#bbb444',
                'parent_id' => 35,
                'slug' => 'unblockaccount',
                'level' => 'issue',
                'type' => 'changerequest',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 37
            array(
                'title' => 'Network Access Right',
                'text_color' => '#ffffff',
                'bg_color' => '#bbb444',
                'parent_id' => 32,
                'slug' => 'networkaccessright',
                'level' => 'subcategory',
                'type' => 'servicerequest',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 38
            array(
                'title' => 'New User Account & Computer Installation',
                'text_color' => '#ffffff',
                'bg_color' => '#abc123',
                'parent_id' => null,
                'slug' => 'newuser',
                'level' => 'category',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 39
            array(
                'title' => 'Create New Account & Computer Installation',
                'text_color' => '#ffffff',
                'bg_color' => '#abc123',
                'parent_id' => 38,
                'slug' => 'createaccount',
                'level' => 'subcategory',
                'type' => 'servicerequest',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 40
            array(
                'title' => 'User Re-Placement',
                'text_color' => '#ffffff',
                'bg_color' => '#cba321',
                'parent_id' => null,
                'slug' => 'userreplacement',
                'level' => 'category',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('ticket_categories')->insert(// 41
            array(
                'title' => 'User & Location',
                'text_color' => '#ffffff',
                'bg_color' => '#cba321',
                'parent_id' => 40,
                'slug' => 'userlocation',
                'level' => 'subcategory',
                'type' => 'servicerequest',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('notices')->insert(
            array(
                'title' => 'System Maintenance',
                'content' => 'ICT System Maintenance Scheduled for March 16, 2024. Expect Temporary Service Disruptions.',
                'category' => 'System',
                'status' => 1,
                'slug' => 'maintenance',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );

        DB::table('notices')->insert(
            array(
                'title' => 'Test',
                'content' => 'test',
                'category' => 'test',
                'status' => 1,
                'slug' => 'test',
                'created_at' => new \DateTime,
                'updated_at' => new \DateTime,
            )
        );
    }
}
