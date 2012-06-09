<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 *
 * <http://www.opensource.org/licenses/lgpl-3.0.html>.
 */

/**
 * @author Christian Münch <c.muench@netz98.de>
 */
class TimestampTask extends Task
{
    /**
     * Property to write timestamp
     *
     * @var string
     */
    protected $property;

    /**
     * Timetamp rule
     *
     * @var string
     */
    protected $rule;

    /**
     * Set format for generated date
     *
     * @var string
     */
    protected $format = '%Y-%m-%d %H:%M:%S';

    /**
     * Set property
     *
     * @param string $property
     * @return void
     */
    public function setProperty($property)
    {
        $this->property = $property;
    }

    /**
     * Set rule to create timestamp
     *
     * @param string $rule
     * @return void
     */
    public function setRule($rule)
    {
        $this->rule = $rule;
    }

    /**
     * Set format of date property
     *
     * @see http://php.net/strftime
     * @param string $format
     * @return void
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * Main -> entry point
     */
    public function main()
    {
        $time = strtotime($this->rule);
        $this->getProject()->setNewProperty($this->property, strftime($this->format, $time));
    }
}