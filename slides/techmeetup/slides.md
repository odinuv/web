---
layout: slides
title: TechMeetup Conference 2023
description: Application Observability from the developers' point of view 
transition: slide
permalink: /slides/techmeetup/
---

<section markdown='1'>
Application Observability: A Developer’s Perspective

Odin (Ondřej Popelka)

--- 
TechMeetup Conference 2023

</section>
{% comment %}
Application Observability from the developers' point of view
{% endcomment %}


<section markdown='1'>
### What I Do
- Senior Backend Engineer at Keboola
- Architecture, Service Design, API Design, Resources setup via Terraform, CI pipelines, Coding, Monitoring, Operations, 24/7 Support, Vacuuming, Washing the dishes, ...
</section>


<section markdown='1'>
## What We do

- Data Operating System, Data Stack, Data processing platform.
- If you have a (big)data problem, we're likely to have it solved.
- If you have 2+ information systems in your company that do not talk to each other, we make them talk.

<img src="/slides/techmeetup/logo.svg" width="400" alt="Keboola Logo" class="noprint" />

</section>
{% comment %}
 If you have this kind of problem, you know immediately that we can solve it for you. If you don't have 
 this kind of problem, it is very difficult to explain to you what we do.
{% endcomment %}


<section markdown='1'>
## What does DevOps do?

- SRE gives us the Kubernetes cluster.
- SRE gives us the networking (private clusters).
- SRE gives us the monitoring tools.
- SRE watches us that we do not do anything *obviously stupid*.
- The UI consumes the API blueprint.

---

**For everything else, there is Devops**
</section>


<section markdown='1'>
## Random Numbers

- 20 domain services (PHP8, NodeJs, GO + lots of Python & PHP7 + bits of Java, PHP5, R)
- 1 monolith service (~7 more domains)
- 1000+ integrations
- 120+ kubernetes nodes, 9 production stacks, 3 clouds (AWS, Azure, GCP)  
- 280+ requests per second, 24+ million / day
- 260.000+ asynchronous jobs a day -- ranging from 1 second to 24 hours
- 1.500.000+ LoC code, 13 developers, 4 SRE
</section>

<section markdown='1'>
## Environment

- High heterogeneity,
- High load variability,
- High request length variability,
- Uneven distribution of requests,

--- 

### Must have
- High automation, High reliability, High observability

</section>

<section markdown='1'>
## Easy part

### Latency is the king
- Latency is what the user feels.
- Measure XXth percentile (p90, p75, p50).
- Big difference means that the service is unstable.

![Good latency](/slides/techmeetup/latency3.png)  
</section>

{% comment %}
that the data is still heavily aggregated - the obvious way how to aggregate is to take the average,
which doesn't work very well, the percentile is better,
p90 means 90% of requests are faster than this, 10% is slower. 
{% endcomment %}

<section markdown='1'>
## Still Easy part
- Graph of obviously bad latency

![Bad latency](/slides/techmeetup/latency1.png)

</section>
{% comment %}
APDEX - measure user satisfaction for a metric for which the target performance has been set
{% endcomment %}


<section markdown='1'>
## Still Easy part ?
- Graph of obviously bad latency:
<img src="/slides/techmeetup/no.jpg" alt="No"
  style="position: absolute;margin-top:-50px;margin-left:200px;"
/>
![Bad latency](/slides/techmeetup/latency2.png)
- APDEX Monitoring -- Application Performance Index ![Apdex](/slides/techmeetup/apdex.png)
</section>


<section markdown='1'>
## Error rate is the Queen

- The very first metric is Error rate
- First to look at when something goes wrong
- First to monitor with APDEX 
<img src="/slides/techmeetup/no.jpg" alt="No"
style="position: absolute;margin-top:40px;margin-left:220px;"
/>
![Error-ish service](/slides/techmeetup/errors.png)
</section>


<section markdown='1'>
## "Weird" API endpoints

- If the request fails, it's actually a valid situation.
- Error rate can be very high, but **never 100%**.
- Always monitor individual endpoints **not services**!
- "Negative" metric -- there must be at least some requests succeeding.
- I do appreciate tips on how to monitor these.
</section>

<section markdown='1'>
## Diagnosing

<img src="/slides/techmeetup/details.png" alt="Old Lady"
style="position: absolute;margin-top:-150px;margin-left:250px;"
/>

- Latency breakdown;
- Breakdown of time spent in "3rd party" services:

![Latency Breakdown](/slides/techmeetup/breakdown.png)
</section>


<section markdown='1'>
## FlameGraph is God

- It is absolutely crucial that they are cross-service. 
- One request:
![Flamegraph](/slides/techmeetup/flamegraph.png)

</section>


<section markdown='1'>
## FlameGraph cont.

- Break down of time spent by the business logic:
![Flamegraph](/slides/techmeetup/flamegraph2.png)

</section>


<section markdown='1'>
## FlameGraph cont.

- Includes time in DB by 3rd party services:
![Flamegraph](/slides/techmeetup/flamegraph3.png)

</section>


<section markdown='1'>
## What are good metrics ?

<img src="/slides/techmeetup/silence.png" alt="Silence"
style="position: absolute;margin-top:-28px;margin-left:250px;"
/>
- Incident proven:
  - 250+ incidents per month,
  - Fail, fail, fail, succeed...

- After an incident:
  - Find what metric/alarm should've triggered;
  - Find metrics that shouldn't have triggered; 
  
---
Metrics give suspicion
× Flamegraphs and traces **give insight**

</section>
{% comment %}
metric != alarm != escalation policy
{% endcomment %}


<section markdown='1'>
## How to get a good metric?

- Must be representative of the end-user experience.
- At the same time it can be totally Meaningless™.
- ex. "Iteration time": 
  - When divided by the <span style='font-size:28pt'>number of jobs it</span><span style='font-size:23pt'> represents the upper bound of the </span><span style='font-size:18pt'>time between a job is received on</span><span style='font-size:13pt'> internal queue and forwarded to the worker </span><span style='font-size:10pt'>to be switched to the processing state and picked up by the processing engine.</span> 
  - It should be between 0.1 and 5
  - Why not 7 ?

- Beware of changes in code that affect the metric!
</section>


<section markdown='1'>
## When watch the metrics?

- When incidents are triggered;
- Ideally every second morning;
- After deploy and During database migrations;
![Versions](/slides/techmeetup/versions.png)
</section>


<section markdown='1'>
## What are the best dashboards?

Eventually all end up like this:

![Dashboard](/slides/techmeetup/dashboard.gif)

**The best ones are those that do not eat your battery when you're on 24/7**

</section>



<section markdown='1'>
## Who's watching the costs?

---

### Budget alerts 
- Everything else is wrong.
- Applies to personal pet projects too.
- Budget alerts also apply to the **cost of the monitoring**.

</section>


<section markdown='1'>
## Hard Part

- Asynchronous jobs
  - Containers that run from seconds to up to days

- Endless loop
  - Non-interactive daemons that run for days to months
  - Queue workers, stream processors, ...

--- 
Some other time...
</section>



<section markdown='1'>
## Thanks

Questions & Comments ?

[linkedin.com/in/odinuv](https://www.linkedin.com/in/odinuv)

--- 

<img src="/slides/techmeetup/logo.svg" width="600" alt="Keboola Logo" />
<img src="/slides/techmeetup/vacancy.gif" alt="Vacancy"
  style="position: relative;height: 180px;z-index: -1000;padding-bottom: 65px;border-radius: 100px;margin-top: -160px;margin-left: 381px;"
/>

[keboola.com/about/jobs](https://www.keboola.com/about/jobs)

</section>

