@extends('layouts.app')

@section('title', 'Jobs')

@section('content')
<style>
    .careers p, li{
        font-size: 20px;
    }
    table {
        width: 80%;
        margin: 20px 20px;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        font-size: 20px;
    }
    th,
    td {
        padding: 10px 12px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f9f9f9;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr:hover {
        background-color: #f1f1f1;
    }
    caption {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    @media screen and (max-width: 768px) {
        .careers p, li{
            font-size: 14px;
        }
        .careers h2,h3{
            font-size: 17px;
        }
        .careers h4{
            font-size: 15px;
        }
        table {
        font-size: 14px;
        width: 90%;
        }
        th,
        td {
        padding: 6px 8px;
        }
        caption {
        font-size: 14px;
        }
    }

    @media screen and (min-width: 1200px) {
        th,
        td {
        padding: 14px 16px;
        }
        caption {
        font-size: 20px;
        }
    }
</style>
<div class="container careers">
    <h1 class="text-center">Careers</h1>
    <h2>Career Opportunities at Swarna Metals Zambia Limited (Kitwe, Copperbelt)</h2>
    <h4>Publication Date: 18th November, 2024.</h4>
    <p>
        Swarna Metals Zambia Limited, a PLR Projects Group Company, is a new and ambitious hydrometallurgical copper extraction plant based in Kitwe, Zambia. We are actively recruiting skilled and experienced professionals to join our team as we prepare to commence production. If you’re ready to contribute your expertise in copper processing to a fast-growing organization in the heart of the Copperbelt, we want to hear from you!
    </p>

    <h2>Position & Number of Openings</h2>
    <table>
    <thead>
        <tr>
        <th>S. No.</th>
        <th>Designation</th>
        <th>Openings</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <td>1</td>
        <td  colspan="2">Crushing Section</td>
        </tr>
        <tr>
        <td></td>
        <td style="text-align: right;">In-charge</td>
        <td>4</td>
        </tr>
        <tr>
        <td>2</td>
        <td colspan="2">Milling and Concentrator Section</td>
        </tr>
        <tr>
        <td></td>
        <td style="text-align: right;">In-charge</td>
        <td>4</td>
        </tr>
        <tr>
        <td>3</td>
        <td  colspan="2">Leaching and PLS Dam Section</td>
        </tr>
        <tr>
        <td></td>
        <td style="text-align: right;">In-charge</td>
        <td>4</td>
        </tr>
        <tr>
        <td>4</td>
        <td colspan="2">Solvent Extraction Section</td>
        </tr>
        <tr>
        <td></td>
        <td style="text-align: right;">In-charge</td>
        <td>4</td>
        </tr>
        <tr>
        <td>5</td>
        <td  colspan="2">Electrowinning Section</td>
        </tr>
        <tr>
        <td></td>
        <td style="text-align: right;">In-charge</td>
        <td>4</td>
        </tr>
        <tr>
        <td>6</td>
        <td  colspan="2">Electrical Maintenance</td>
        </tr>
        <tr>
        <td></td>
        <td style="text-align: right;">In-charge</td>
        <td>4</td>
        </tr>
        <tr>
        <td>7</td>
        <td  colspan="2">Mechanical Maintenance</td>
        </tr>
        <tr>
        <td></td>
        <td style="text-align: right;">In-charge</td>
        <td>4</td>
        </tr>
        <tr>
        <td>8</td>
        <td  colspan="2">Laboratory</td>
        </tr>
        <tr>
        <td></td>
        <td style="text-align: right;">In-charge</td>
        <td>4</td>
        </tr>
        <tr>
        <td>9</td>
        <td  colspan="2">Garage</td>
        </tr>
        <tr>
        <td></td>
        <td style="text-align: right;">In-charge</td>
        <td>4</td>
        </tr>
        <tr>
        <td></td>
        <td style="text-align: right;">Auto Electrician</td>
        <td>8</td>
        </tr>
        <tr>
        <td>10</td>
        <td>HR Officer</td>
        <td>1</td>
        </tr>
        <tr>
        <td>11</td>
        <td>Safety Officer</td>
        <td>1</td>
        </tr>
        <tr>
        <td>12</td>
        <td>Stores</td>
        <td>1</td>
        </tr>
    <tr>
        <td></td>
        <td style="text-align: right; font-weight:bold;">Total</td>
        <td style="font-weight:bold;">47</td>
        </tr>
    </tbody>
    </table>

    <h3>Open Positions (Brief Job Description & Qualification)</h3>

    <div>
        <h3>1. Crushing Section In-charge</h3>
        <p><strong>Job Description</strong></p>
        <p>Lead and manage the crushing operations to ensure efficient ore size reduction for downstream processing.</p>
        <p>Monitor equipment performance, manage production rates, and ensure safe operations.</p>
        <p>Implement regular inspections and maintenance of crushing equipment.</p>
        <p><strong>Qualifications Required</strong></p>
        <ul>
            <li>Bachelor’s Degree in Mining Engineering, Metallurgy, or Mechanical Engineering.</li>
            <li>Minimum of 5 years of experience in ore crushing operations.</li>
            <li>Strong understanding of crushing machinery and safety protocols.</li>
        </ul>
    </div>

    <div>
        <h3>2. Milling and Concentrator Section In-charge</h3>
        <p><strong>Job Description</strong></p>
        <p>Lead and oversee operations in the Milling and Concentrator section, ensuring optimal grinding, flotation, and material handling processes.</p>
        <p>Maintain production targets, quality control, and efficient use of resources in the concentrator.</p>
        <p>Ensure strict adherence to safety protocols and environmental compliance.</p>
        <p>Provide training and support to staff within the section.</p>
        <p><strong>Qualifications Required</strong></p>
        <ul>
            <li>Bachelor’s Degree in Metallurgy, Mining Engineering, or a related field.</li>
            <li>Minimum of 5 years of hands-on experience in milling and flotation operations within the mining or mineral processing sector.</li>
            <li>Strong leadership skills with a focus on efficiency and safety.</li>
        </ul>
    </div>

    <div>
        <h3>3. Leaching and PLS Dam Section In-charge</h3>
        <p><strong>Job Description</strong></p>
        <p>Supervise the leaching processes and manage the PLS (Pregnant Leach Solution) dam to ensure high-quality output for downstream processing.</p>
        <p>Monitor and adjust chemical dosages, pH levels, and leach time to achieve optimal copper recovery.</p>
        <p>Ensure proper maintenance of leaching and PLS infrastructure while adhering to environmental standards.</p>
        <p><strong>Qualifications Required</strong></p>
        <ul>
            <li>Bachelor’s Degree in Metallurgy, Chemical Engineering, or a related discipline.</li>
            <li>At least 5 years of experience in leaching operations within a hydrometallurgical setting.</li>
            <li>Strong knowledge of PLS management and copper extraction chemistry.</li>
        </ul>
    </div>

    <div>
        <h3>4. Solvent Extraction Section In-charge</h3>
        <p><strong>Job Description</strong></p>
        <p>Oversee the solvent extraction process, ensuring efficient copper transfer from PLS to the electrowinning feed.</p>
        <p>Manage solvent inventory, optimize extraction cycles, and maintain consistent production rates.</p>
        <p>Ensure adherence to health, safety, and environmental standards in the section.</p>
        <p><strong>Qualifications Required</strong></p>
        <ul>
            <li>Bachelor’s Degree in Chemistry, Metallurgy, or Process Engineering.</li>
            <li>Minimum of 5 years of relevant experience in solvent extraction operations, preferably in the mining industry.</li>
            <li>Proficiency in SX plant operation, chemical handling, and troubleshooting.</li>
        </ul>
    </div>

    <div>
        <h3>5. Electrowinning Section In-charge</h3>
        <p><strong>Job Description</strong></p>
        <p>Manage the electrowinning section to ensure maximum copper cathode production with high purity.</p>
        <p>Supervise tankhouse operations, monitor electrode health, and oversee plating cycles.</p>
        <p>Ensure the safety and maintenance of electrowinning equipment while adhering to industry standards.</p>
        <p><strong>Qualifications Required</strong></p>
        <ul>
            <li>Bachelor’s Degree in Metallurgy, Electrical Engineering, or Process Engineering.</li>
            <li>Minimum of 5 years of experience in electrowinning processes.</li>
            <li>Essential knowledge of electrode and cathode production processes.</li>
        </ul>
    </div>

    <div>
        <h3>6. Electrical Maintenance In-charge</h3>
        <p><strong>Job Description</strong></p>
        <p>Oversee all electrical maintenance activities across the plant, ensuring equipment reliability and minimal downtime.</p>
        <p>Develop and implement preventive maintenance schedules for electrical systems.</p>
        <p>Ensure compliance with electrical safety standards.</p>
        <p>Handle 11 kV HV equipment, HV motors, and PLC automation systems.</p>
        <p><strong>Qualifications Required</strong></p>
        <ul>
            <li>Bachelor’s Degree in Electrical Engineering or equivalent.</li>
            <li>Minimum of 5 years of experience in electrical maintenance, preferably in the mining or industrial sector.</li>
            <li>Strong knowledge of electrical systems in mining and processing plants.</li>
        </ul>
    </div>

    <div>
        <h3>7. Mechanical Maintenance Section In-charge</h3>
        <p><strong>Job Description</strong></p>
        <p>Lead the maintenance team to ensure optimal performance of all mechanical equipment across the plant.</p>
        <p>Develop and implement preventive maintenance schedules for milling, leaching, and electrowinning equipment.</p>
        <p>Troubleshoot and resolve mechanical issues to minimize downtime and ensure smooth operations.</p>
        <p><strong>Qualifications Required</strong></p>
        <ul>
            <li>Bachelor’s Degree in Mechanical Engineering or a related field.</li>
            <li>Minimum of 5 years of experience in maintenance within the mining or industrial processing sector.</li>
            <li>Strong knowledge of mechanical systems, maintenance planning, and problem-solving.</li>
        </ul>
    </div>

    <div>
        <h3>8. Laboratory In-charge</h3>
        <p><strong>Job Description</strong></p>
        <p>Manage laboratory operations to ensure accurate and timely testing of materials, including ore, concentrate, and process solutions.</p>
        <p>Maintain quality control, oversee laboratory staff, and ensure compliance with industry standards.</p>
        <p><strong>Qualifications Required</strong></p>
        <ul>
            <li>Bachelor’s Degree in Chemistry, Metallurgy, or a related field.</li>
            <li>Minimum of 5 years of experience in laboratory management within the mining or mineral processing industry.</li>
            <li>Strong understanding of analytical techniques and quality control.</li>
        </ul>
    </div>

    <div>
        <h3>9. Garage</h3>
        <h4>I) In-charge</h4>
        <p><strong>Job Description</strong></p>
        <p>Oversee the maintenance and repair of all plant vehicles and mobile equipment.</p>
        <p>Ensure all equipment is in good working condition and safety protocols are strictly followed.</p>
        <p>Develop and implement preventive maintenance schedules for fleet and mobile equipment.</p>
        <p><strong>Qualifications Required</strong></p>
        <ul>
            <li>Diploma or Degree in Mechanical Engineering or Automotive Engineering.</li>
            <li>Minimum of 5 years of experience in automotive or equipment maintenance, preferably within the mining industry.</li>
            <li>Strong knowledge of heavy equipment maintenance.</li>
        </ul>

        <h4>II) Auto Electrician</h4>
        <p><strong>Job Description</strong></p>
        <p>As an Auto Electrician, you will be responsible for diagnosing, repairing, and maintaining the electrical systems of our fleet of vehicles and heavy equipment. Your role is crucial in ensuring the operational efficiency and safety of our machinery.</p>
        <p><strong>Key Responsibilities</strong></p>
        <ul>
            <li>Diagnose and repair electrical faults in vehicles and heavy equipment.</li>
            <li>Install, maintain, and repair wiring and electrical components.</li>
            <li>Utilize diagnostic tools and software to troubleshoot issues.</li>
            <li>Collaborate with the maintenance team to ensure timely repairs.</li>
            <li>Adhere to safety protocols and industry standards.</li>
        </ul>
        <p><strong>Qualifications Required</strong></p>
        <ul>
            <li>Diploma or Degree in Mechanical Engineering or Automotive Engineering.</li>
            <li>Grade 12 Certificate with passes in Mathematics and Science.</li>
            <li>Certification: Craft Certificate in Auto Electrical or a related field from a recognized institution.</li>
            <li>At least 2 years of practical experience in auto electrical repairs and maintenance, preferably with light and heavy-duty vehicles.</li>
            <p style="font-size:15px; margin:5px 0px;"><strong>Technical Skills:</strong></p>
            <li>Basic knowledge of vehicle wiring and electrical systems.</li>
            <li>Ability to diagnose and repair electrical faults using standard tools.</li>
            <li>Familiarity with common diagnostic tools and equipment.</li>
            <li>Valid driver’s license (optional but preferred).</li>
            <li>Understanding of workplace health and safety standards.</li>
            <li>Ability to work in a team-oriented environment.</li>
        </ul>
    </div>

    <div>
        <h3>10. HR Officer</h3>
        <p><strong>Job Description</strong></p>
        <p>The HR Officer will lead all human resource activities at the plant and report directly to the Plant Head.</p>
        <p>This role includes overseeing employee management, compliance, training, and development while supervising the HR staff responsible for Security and Public Relations (PRO). The HR Officer will work closely with the management team to align HR strategies with the plant’s operational goals.</p>
        <p><strong>Key Responsibilities</strong></p>
        <ul>
            <li>Manage the entire employee lifecycle, including recruitment, onboarding, training, payroll, and exit formalities.</li>
            <li>Supervise HR staff responsible for Security and PRO functions, ensuring effective operations and alignment with plant objectives.</li>
            <li>Develop and enforce HR policies and ensure compliance with labor laws and regulations.</li>
            <li>Address employee grievances and foster a positive workplace culture.</li>
            <li>Maintain accurate employee records, attendance, and payroll data.</li>
            <li>Oversee the implementation of employee welfare programs and safety initiatives.</li>
            <li>Provide insights and HR reports to the Plant Head to support strategic decision-making.</li>
        </ul>
        <p><strong>Qualifications Required</strong></p>
        <ul>
            <li>Bachelor’s or Master’s degree in Human Resources, Business Administration, or a related field.</li>
            <li>5+ years of experience in HR management, preferably in a manufacturing or industrial setup.</li>
            <li>Strong knowledge of labor laws, compliance, and HR best practices.</li>
            <li>Excellent interpersonal and communication skills with the ability to manage diverse teams.</li>
            <li>Proven experience in handling employee grievances and fostering a positive work environment.</li>
            <li>Proficiency in HRMS software and MS Office applications.</li>
        </ul>
    </div>

    <div>
        <h3>11. Safety Officer</h3>
        <p><strong>Job Description</strong></p>
        <p>The Safety Officer will be responsible for ensuring a safe and secure working environment at the plant, reporting directly to the Plant Head.</p>
        <p>This includes implementing safety protocols, conducting risk assessments, and ensuring compliance with safety standards. The Safety Officer will play a key role in cultivating a safety culture among all employees.</p>
        <p><strong>Key Responsibilities</strong></p>
        <ul>
            <li>Conduct safety audits, risk assessments, and inspections to identify potential hazards.</li>
            <li>Develop, implement, and enforce safety policies and procedures in line with regulations.</li>
            <li>Investigate workplace incidents, identify root causes, and recommend preventive measures.</li>
            <li>Conduct safety training and awareness programs for employees.</li>
            <li>Monitor the use of Personal Protective Equipment (PPE) and ensure adherence to safety practices.</li>
            <li>Maintain safety documentation and ensure compliance with legal and regulatory requirements.</li>
            <li>Report safety performance metrics and improvements directly to the Plant Head.</li>
        </ul>
        <p><strong>Qualifications Required</strong></p>
        <ul>
            <li>Bachelor’s degree in Occupational Health and Safety, Engineering, or a related field.</li>
            <li>Certification in safety management (e.g., NEBOSH, IOSH, or equivalent) is highly preferred.</li>
            <li>Minimum of 3–5 years of experience in safety management within an industrial or manufacturing environment.</li>
            <li>In-depth knowledge of health and safety regulations and standards.</li>
            <li>Strong analytical and problem-solving skills to assess risks and develop solutions.</li>
            <li>Proficiency in preparing safety reports and conducting safety training programs.</li>
        </ul>
    </div>

    <div>
        <h3>12. Stores Incharge</h3>
        <p><strong>Job Description</strong></p>
        <p>The Stores Incharge will oversee the management of plant inventory, reporting directly to the Plant Head.</p>
        <p>This role involves managing the receipt, storage, and issuance of materials and equipment while maintaining optimal stock levels to support smooth plant operations.</p>
        <p><strong>Key Responsibilities</strong></p>
        <ul>
            <li>Oversee the receipt, inspection, storage, and issuance of materials, tools, and equipment.</li>
            <li>Maintain accurate inventory records and conduct regular stock audits.</li>
            <li>Monitor inventory levels and coordinate with the procurement team for timely replenishments.</li>
            <li>Ensure proper storage conditions and prevent material loss or damage.</li>
            <li>Develop and implement efficient procedures for inventory management.</li>
            <li>Collaborate with other departments to ensure the timely availability of resources.</li>
            <li>Generate and present inventory reports directly to the Plant Head.</li>
        </ul>
        <p><strong>Qualifications Required</strong></p>
        <ul>
            <li>Bachelor’s degree in Supply Chain Management, Logistics, Business Administration, or a related field.</li>
            <li>3+ years of experience in inventory or stores management, preferably in a manufacturing environment.</li>
            <li>Strong knowledge of inventory control processes and best practices.</li>
            <li>Familiarity with ERP systems or inventory management software.</li>
            <li>Excellent organizational and multitasking skills.</li>
            <li>Strong communication and coordination skills to work with cross-functional teams.</li>
        </ul>
    </div>
    <!-- Repeat similar structure for other roles -->

    <h3>General Requirements for All Positions</h3>
    <ul>
        <li>Proven experience of at least 5 years in a relevant field.</li>
        <li>Solid leadership and supervisory skills.</li>
        <li>Excellent problem-solving abilities and attention to detail.</li>
        <li>Strong communication and organizational skills.</li>
        <li>Commitment to safety and environmental compliance.</li>
    </ul>

    <p><strong>Application Process</strong></p>
    <p>Please submit your application, including:</p>
    <ul>
        <li>A detailed CV.</li>
        <li>A cover letter.</li>
        <li>Certified copies of academic and professional certificates.</li>
    </ul>

    <p><strong>Submission Options:</strong></p>
    <ul>
        <li>Email: hr@plrprojects.com</li>
        <li>In Person: Human Resource Department, Swarna Metals Zambia Limited, a PLR Group Company, F/4213/A, Sabina Mufulira Road, Kitwe - 50100, Copperbelt, Zambia</li>
    </ul>

    <p><strong>Application Deadline:</strong> 31st December 2024</p>
    <p><strong>Why Join Us?</strong> Be part of a dynamic team driving innovation in Zambia’s copper industry. Join us in our journey towards excellence!</p>

</div>
@endsection

