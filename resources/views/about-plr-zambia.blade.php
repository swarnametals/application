@extends('website-layouts.app')

@section('title', 'About PLR Zambia')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h1, h2 {
        /* color: #2c3e50; */
        color: #000000;
        margin-bottom: 15px;
    }

    h1 {
        font-size: 2.5em;
        text-align: center;
    }

    h2 {
        font-size: 1.8em;
        border-bottom: 3px solid #ff5733;
        color: #444;
        padding-bottom: 5px;
        margin-top: 30px;
    }

    .about-plr p, ul {
        margin-bottom: 15px;
        font-size: 20px;
    }

    ul {
        padding-left: 20px;
    }

    ul li {
        margin-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
        font-size: 16px;
        overflow-x: auto;
        /* display: block; */
    }

    table .grade-header {
        background-color: #510404;
        color: white;
        font-weight: bold;
    }

    table .grade-header:hover {
        background-color: #710909;
        color: white;
    }

    th, td {
        text-align: left;
        padding: 10px;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    tr:hover {
        background-color: #f9f9f9;
    }

    @media (max-width: 768px) {
        body {
            font-size: 14px;
        }

        h1 {
            font-size: 2em;
        }

        h2 {
            font-size: 1.5em;
        }

        .about-plr p, ul {
            margin-bottom: 15px;
            font-size: 14px;
        }

        table {
            font-size: 14px;
        }

        th, td {
            padding: 8px;
        }
    }
</style>

<div class="container about-plr">
    <h1>About PLR Zambia</h1>

    <section>
        <h2>PLR Projects' Journey into Zambia</h2>
        <p>
            In 2011, M/S PLR conducted surveys in Tanzania and Zambia to identify investment opportunities in mining and allied industries.
            This initiative led to the incorporation of PLR Projects Zambia Limited, marking the company’s entry into Zambia’s mining sector.
            The initial focus was on establishing a ferroalloy business, which laid the foundation for the company’s growth.
        </p>
    </section>

    <section>
        <h2>Strategic Location and Logistics</h2>
        <p>
            Zambia, located in southern-central Africa, shares borders with Tanzania, the Democratic Republic of the Congo, Angola, Zimbabwe, Malawi, Namibia, and Mozambique.
            The nearest port facility is Dar es Salaam in Tanzania, approximately 1,900 kilometers by road from Mansa in Zambia’s Luapula Province, where the mining site is situated.
            The capital city, Lusaka, is about 800 kilometers from Mansa, with Serenje located along the route.
        </p>
    </section>

    <section>
        <h2>Ferro Alloy Plant</h2>
        <p>
            PLR Projects Zambia Limited planned to establish a Ferro Alloy Plant with an initial capacity of <strong>2 x 9 MVA</strong>, expandable up to <strong>54 MVA</strong>, in Serenje, Central Province.
            Land for the plant was acquired in Pensulo village, approximately 440 kilometers from Lusaka.
            Key raw materials such as manganese, quartz, dolomite, and coal are locally available, while coke is imported from neighboring Zimbabwe.
        </p>
        <p>
            The first phase of the <strong>9 MVA</strong> PLR Ferro Alloy Plant was completed, and commercial production began in May 2017.
            The plant is designed to produce ferro silicon, ferro manganese, and silico manganese. Initially, production focused on silico manganese.
            The product is exported to markets including Dubai, Japan, South Africa, Kenya, and Tanzania.
        </p>
        <p>
            Construction of the second phase of the Ferro Alloy Plant, with an additional <strong> 10 MVA </strong> capacity, was initiated and was expected to commence commercial production during 2019.
            This expansion underscores PLR Projects’ commitment to strengthening its presence in Zambia’s mining and industrial sectors.
        </p>
    </section>

    <section>
        <h2>Silico Manganese Specifications</h2>
        <p>
            Silico Manganese (SiMn) is a vital alloy used in steelmaking and foundry industries, offering strength, durability, and improved wear resistance.
            Below are the specifications of our standard grades to help meet your industrial requirements.
        </p>
    </section>

    <section>
        <h2 style="text-align: center;">Standard Grades</h2>
        <table>
            <thead>
            <tr>
                <th>Specification</th>
                <th>Details</th>
            </tr>
            </thead>
            <tbody>
            <tr class="grade-header">
                <td colspan="2">Grade: SiMn 60/14</td>
            </tr>
            <tr>
                <td>Manganese (Mn)</td>
                <td>60% minimum</td>
            </tr>
            <tr>
                <td>Silicon (Si)</td>
                <td>14% minimum</td>
            </tr>
            <tr>
                <td>Carbon (C)</td>
                <td>2.0% maximum</td>
            </tr>
            <tr>
                <td>Phosphorus (P)</td>
                <td>0.3% maximum</td>
            </tr>
            <tr>
                <td>Sulfur (S)</td>
                <td>0.03% maximum</td>
            </tr>

            <tr class="grade-header">
                <td colspan="2">Grade: SiMn 65/17</td>
            </tr>
            <tr>
                <td>Manganese (Mn)</td>
                <td>65% minimum</td>
            </tr>
            <tr>
                <td>Silicon (Si)</td>
                <td>17% minimum</td>
            </tr>
            <tr>
                <td>Carbon (C)</td>
                <td>2.0% maximum</td>
            </tr>
            <tr>
                <td>Phosphorus (P)</td>
                <td>0.3% maximum</td>
            </tr>
            <tr>
                <td>Sulfur (S)</td>
                <td>0.03% maximum</td>
            </tr>

            <tr class="grade-header">
                <td colspan="2">Grade: SiMn 68/18</td>
            </tr>
            <tr>
                <td>Manganese (Mn)</td>
                <td>68% minimum</td>
            </tr>
            <tr>
                <td>Silicon (Si)</td>
                <td>18% minimum</td>
            </tr>
            <tr>
                <td>Carbon (C)</td>
                <td>2.0% maximum</td>
            </tr>
            <tr>
                <td>Phosphorus (P)</td>
                <td>0.3% maximum</td>
            </tr>
            <tr>
                <td>Sulfur (S)</td>
                <td>0.03% maximum</td>
            </tr>
            </tbody>
        </table>
    </section>

    <section>
        <h2 style="text-align: center;">Balance: Iron (Fe)</h2>
        <table>
        <thead>
            <tr>
            <th class="grade-header" colspan="2">Physical Properties</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>Appearance</td>
            <td>Metallic lumps with a steel-gray color</td>
            </tr>
            <tr>
            <td>Density</td>
            <td>~6.1 g/cm³</td>
            </tr>
            <tr>
            <td>Melting Range</td>
            <td>1060°C to 1350°C</td>
            </tr>
        </tbody>
        </table>

        <h2>Applications</h2>
        <h2>Silico Manganese is essential For</h2>
        <p><strong>1. Steel Making</strong></p>
        <ul>
            <li>Acts as a deoxidizer to remove oxygen impurities, producing cleaner, stronger steel.</li>
            <li>Serves as an alloying agent to enhance strength, hardness, and wear resistance.</li>
        </ul>

        <p><strong>2. Foundry Applications:</strong></p>
        <ul>
            <li>Improves elasticity, magnetic properties, and thermal resistance of metal castings.</li>
        </ul>
    </section>

    <section>
        <h2>Copper Business</h2>
        <p>
            In 2022, PLR Projects expanded its operations by establishing a new copper business under its subsidiary, Swarna Metals Zambia Limited (SMZL).
            Located on Sabina Mufulira Road, approximately 25 kilometers from Kitwe in Zambia’s Copperbelt Province, SMZL is a state-of-the-art greenfield hydrometallurgical copper extraction plant.
        </p>
    </section>

    <section>
        <h2>Commitment to Zambia's Growth and Sustainability</h2>
        <p>
            SMZL integrates cutting-edge technology, sustainability, and operational excellence, positioning itself as a key player in Zambia’s copper processing industry.
            With a milling capacity of <strong>1,200 tons per day</strong>, expandable to <strong>2,400 tons per day</strong>, the plant reflects PLR’s commitment to value addition across the copper value chain.
            The vision of SMZL aligns with Zambia’s industrial growth strategy, fostering innovation and sustainable development in the Copperbelt Province.
        </p>
        <p>
            By diversifying its portfolio, PLR Projects has reinforced its role as a significant contributor to Zambia’s industrial and economic progress.
        </p>
    </section>

    <section>
        <h2>Why Choose Us</h2>
        <ul>
            <li><strong>Consistent Quality:</strong> We adhere to strict quality standards to ensure high-grade alloys.</li>
            <li><strong>Customized Solutions:</strong> Tailored specifications available to meet unique industrial needs.</li>
            <li><strong>Reliable Supply:</strong> Efficient production and logistics ensure timely delivery.</li>
        </ul>
        <p style="font-style: italic;">"Contact us today to learn more about our products and how they can support your operations."</p>
    </section>
</div>
@endsection
